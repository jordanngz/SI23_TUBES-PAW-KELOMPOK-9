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

    /**
     * Ambil daftar meja special yang tersedia dari microservice.
     */
    public function getAvailableTables(string $date, string $time, int $partySize): array
    {
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("{$this->baseUrl}/api/special/tables", [
                    'date'       => $date,
                    'time'       => $time,
                    'party_size' => $partySize,
                ]);

            if ($response->successful()) {
                return $response->json('tables', []);
            }

            Log::warning('[SpecialTableService] getAvailableTables failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('[SpecialTableService] getAvailableTables exception: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Kirim data form ke microservice untuk validasi, 
     * dan terima session_data yang akan disimpan main app ke session.
     */
    public function storeTempReservation(array $data): array
    {
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->post("{$this->baseUrl}/api/special/temp", $data);

            if ($response->successful()) {
                return [
                    'success'      => true,
                    'session_data' => $response->json('session_data', []),
                    'message'      => $response->json('message', 'OK'),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message', 'Microservice error: ' . $response->status()),
            ];
        } catch (\Throwable $e) {
            Log::error('[SpecialTableService] storeTempReservation exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Cannot reach special table service.'];
        }
    }

    /**
     * Konfirmasi reservasi special setelah payment sukses — 
     * microservice update kolom special fields di DB.
     */
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

    /**
     * Ambil detail satu special reservation.
     */
    public function getReservation(int $id): ?array
    {
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("{$this->baseUrl}/api/special/{$id}");

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::error('[SpecialTableService] getReservation exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Batalkan special reservation.
     */
    public function cancelReservation(int $id): bool
    {
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->delete("{$this->baseUrl}/api/special/{$id}");

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('[SpecialTableService] cancelReservation exception: ' . $e->getMessage());
            return false;
        }
    }
}
