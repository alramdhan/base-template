<?php

namespace App\Services;

use App\Models\UserDevice;
use Exception;
use Illuminate\Support\Facades\Cache;

class BiometricAuthService
{
	/**
	 * Fungsi utama yang akan dipanggil
	*/
	public function authenticate(array $data, array $headers): array
	{
		if(!$headers['payload'] || !$headers['signature']) {
			throw new Exception('keamanan header tidak lengkap', 401);
		}

		$device = UserDevice::where('device_id', $data['device_id'])->first();
		if(!$device) {
			throw new Exception('Perangkat tidak dikenali', 404);
		}

		$this->preventReplayAttack($headers['payload']);
		$this->veriryCryptography($headers['payload'], $headers['signature'], $device->public_key);

		$user = $device->user;
		$user->tokens()->delete();
		$token = $user->createToken('api_token')->plainTextToken;

		return [
			'user' => $user,
			'access_token' => $token,
			'token_type' => 'Bearer'
		];
	}

	private function veriryCryptography(string $payload, string $signature64, string $publicKey): void
	{
		$signature = base64_decode($signature64);
		$isValid = openssl_verify($payload, $signature, $publicKey, OPENSSL_ALGO_SHA256);

		if($isValid !== 1) {
			throw new Exception('Kredensial biometrik tidak valid', 401);
		}
	}

	/**
     * Memastikan payload tidak kedaluwarsa dan tidak dikirim ulang
     */
    private function preventReplayAttack(string $payload): void
    {
        $payloadParts = explode('|', $payload);
        
        if (count($payloadParts) !== 2) {
            throw new Exception('Format payload tidak valid.', 400);
        }

        $clientTimestamp = (int) $payloadParts[0];
        $nonce = $payloadParts[1];

        // Cek kedaluwarsa (Toleransi 60 detik)
        $timeDifference = abs(now()->timestamp - $clientTimestamp);
        
        if ($timeDifference > 120) {
            throw new Exception('Sesi biometrik kedaluwarsa. Pastikan jam di perangkat Anda akurat.', 401);
        }

        // Cek Uniqueness di Cache
        $cacheKey = 'biometric_nonce_' . $nonce;

        if (Cache::has($cacheKey)) {
            throw new Exception('Terdeteksi permintaan berulang (Replay Attack).', 401);
        }

        Cache::put($cacheKey, true, 120);
    }
}