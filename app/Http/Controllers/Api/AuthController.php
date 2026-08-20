<?php

namespace App\Http\Controllers\Api;

use App\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\BiometricLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\BiometricAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponse;

    protected BiometricAuthService $biometricService;

    public function __construct(BiometricAuthService $biometricService)
    {
        $this->biometricService = $biometricService;
    }

    public function registerBiometric(Request $request): JsonResponse
    {
        $request->validate([
            'device_id' => ['required', 'string', 'max:255'],
            'device_model' => ['nullable', 'string', 'max:255'],
            'public_key' => ['required', 'string'],
            'user_pin' => ['required', 'string', 'min:6']
        ]);
        $user = $request->user();
        $plainBiometricToken = Str::random(64);

        // Simpan ke database dengan metode Hash (seperti password)
        UserDevice::updateOrCreate(
            ['device_id' => $request->device_id],
            [
                'user_id' => $user->id,
                'device_model' => $request->device_model,
                'public_key' => $request->public_key
            ]
        );

        return $this->successResponse([
            // Mobile HARUS menyimpan token ini di OS Secure Enclave / Keystore
            'biometric_token' => $plainBiometricToken 
        ], 'Biometrik berhasil didaftarkan pada perangkat ini.');
    }

    public function verifyBiometric(BiometricLoginRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $secureHeaders = $request->getSecurityHeaders();
            $authData = $this->biometricService->authenticate($validatedData, $secureHeaders);

            return $this->successResponse($authData, 'Login biometrik berhasil');
        } catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 401;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }
    
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->credentials();
        $loginField = isset($credentials['email']) ? 'email' : 'username';

        $user = User::where($loginField, $credentials[$loginField])->first();
        // dd($user);

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Username atau Password tidak valid!', 401);
        }

        // pembatasan token lama
        $user->tokens()->delete($user->name, 'api_token');
        $expiresAt = $request->remember_me ? now()->addMonths(6) : now()->addHours(24);
        // buat token baru
        $token = $user->createToken('api_token', ['*'], $expiresAt)->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt
        ], 'Login Berhasil');
    }

    /**
     * Handle API Logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        // Parameter pertama (data) bisa dikosongkan/null jika hanya mengirim pesan
        return $this->successResponse(null, 'Logout berhasil');
    }
}
