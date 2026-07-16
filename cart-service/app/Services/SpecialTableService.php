<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpecialTableService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.special_table.url', 'http://special-table-service:8000'), '/');
        $this->token   = config('services.special_table.token', 'kerapu-special-table-secret-2026');
    }

    public function confirmReservation(array $data): array
    {
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->post("{$this->baseUrl}/api/special/confirm", $data);

            if ($response->successful()) {
                return ['success' => true, 'message' => $response->json('message', 'Confirmed')];
            }

            Log::warning('[SpecialTableService] confirmReservation failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return ['success' => false, 'message' => 'Special confirmation failed.'];
        } catch (\Throwable $e) {
            Log::error('[SpecialTableService] confirmReservation exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Cannot reach special table service.'];
        }
    }
}
