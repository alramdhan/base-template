<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Menghapus spasi berlebih di awal/akhir input yang sering tidak disengaja oleh user
            'login' => trim($this->input('login')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            // 'remember_me' => ['boolean']
        ];
    }

    /**
     * Kustomisasi pesan error validasi input.
     */
    public function messages(): array
    {
        return [
            'login.required'    => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal harus :min karakter.',
        ];
    }

    /**
     * Get the credentials array based on email or username.
     *
     * @return array
     */
    public function credentials(): array
    {
        $login = $this->input('login');

        // Cek apakah format string adalah email yang valid
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $fieldType => $login,
            'password' => $this->input('password'),
        ];
    }
}
