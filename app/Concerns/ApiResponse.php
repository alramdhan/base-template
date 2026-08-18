<?php

namespace App\Concerns;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Berikan respons sukses (HTTP 200/201)
     */
    protected function successResponse(mixed $data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $statusCode);
    }

    /**
     * Berikan respons error (HTTP 400/401/403/404/500)
     */
    protected function errorResponse(string $message, int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        // Jika ada detail error tambahan (misal error validasi khusus), tampilkan
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
