<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiometricLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'device_id' => ['required', 'string'],
            // 'payload' => ['required', 'string'],
            // 'signature' => ['required', 'string'],
        ];
    }

    /**
     * Method tambahan untuk mengambil data keamanan dari Header
     */
    public function getSecurityHeaders(): array
    {
        return [
            'payload' => $this->header('X-Biometric-Payload'),
            // 'timestamp' => $this->header('X-Biometric-Timestamp'),
            // 'nonce'     => $this->header('X-Biometric-Nonce'),
            'signature' => $this->header('X-Biometric-Signature'),
            'path'      => $this->getPathInfo(), // '/api/biometric/login'
            'body'      => $this->getContent(),  // Raw JSON String dari body
        ];
    }
}
