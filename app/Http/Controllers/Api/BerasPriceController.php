<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BerasPrice\UpdateBerasPriceRequest;
use App\Http\Resources\BerasPriceResource;
use App\Models\BerasPrice;
use Illuminate\Http\JsonResponse;

/**
 * Harga beras acuan zakat fitrah.
 *
 * Kontrak: openapi.yaml#/paths/~1beras-price
 */
class BerasPriceController extends Controller
{
    /**
     * GET /api/beras-price — harga terkini (publik).
     */
    public function show(): JsonResponse
    {
        $current = BerasPrice::with('updater')->latest('id')->first();

        if ($current === null) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        return response()->json([
            'data' => new BerasPriceResource($current),
        ]);
    }

    /**
     * PUT /api/beras-price — perbarui harga (admin).
     *
     * Harga selalu ditambahkan sebagai record baru supaya riwayat perubahan
     * tetap terekam; "harga terkini" adalah record dengan updated_at terbaru.
     */
    public function update(UpdateBerasPriceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $price = BerasPrice::create([
            'price' => $data['price'],
            'note' => $data['note'] ?? null,
            'updated_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Harga beras diperbarui',
            'data' => new BerasPriceResource($price->load('updater')),
        ]);
    }
}