<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kalkulator\ZakatFitrahRequest;
use App\Http\Requests\Kalkulator\ZakatMalRequest;
use App\Models\BerasPrice;
use Illuminate\Http\JsonResponse;

/**
 * Kalkulator zakat (stateless, tanpa menyimpan data).
 *
 * Kontrak: openapi.yaml#/paths/~1kalkulator~1{zakat-fitrah,zakat-mal}
 */
class KalkulatorController extends Controller
{
    /** Harga beras per kg cadangan bila DB belum punya data (rupiah). */
    private const HARGA_BERAS_DEFAULT = 16000;

    /** Harga emas per gram cadangan bila tidak diisi (rupiah). */
    private const HARGA_EMAS_DEFAULT = 1100000;

    /** Nishab zakat mal: 85 gram emas. */
    private const NISHAB_EMAS_GRAM = 85;

    /** Kadar zakat mal: 2.5%. */
    private const KADAR_ZAKAT_MAL = 2.5;

    /** Beras per jiwa untuk zakat fitrah: 2.5 kg. */
    private const BERAS_PER_JIWA_KG = 2.5;

    /**
     * POST /api/kalkulator/zakat-fitrah
     */
    public function zakatFitrah(ZakatFitrahRequest $request): JsonResponse
    {
        $data = $request->validated();
        $jumlahJiwa = (int) $data['jumlah_jiwa'];

        // Tentukan harga beras: override > database > default.
        if (! empty($data['harga_beras_override'])) {
            $hargaBeras = (int) $data['harga_beras_override'];
            $sumber = 'override';
        } else {
            $current = BerasPrice::current();
            if ($current !== null) {
                $hargaBeras = (int) $current->price;
                $sumber = 'database';
            } else {
                $hargaBeras = self::HARGA_BERAS_DEFAULT;
                $sumber = 'default';
            }
        }

        $berasKg = $jumlahJiwa * self::BERAS_PER_JIWA_KG;
        $totalRupiah = (int) round($berasKg * $hargaBeras);

        return response()->json([
            'data' => [
                'jumlah_jiwa' => $jumlahJiwa,
                'harga_beras_per_kg' => $hargaBeras,
                'beras_kg' => $berasKg,
                'total_rupiah' => $totalRupiah,
                'harga_beras_sumber' => $sumber,
            ],
        ]);
    }

    /**
     * POST /api/kalkulator/zakat-mal
     */
    public function zakatMal(ZakatMalRequest $request): JsonResponse
    {
        $data = $request->validated();
        $totalHarta = (int) $data['total_harta'];
        $hargaEmas = (int) ($data['harga_emas_per_gram'] ?? self::HARGA_EMAS_DEFAULT);

        $nishab = self::NISHAB_EMAS_GRAM * $hargaEmas;
        $wajibZakat = $totalHarta >= $nishab;
        $zakat = $wajibZakat
            ? (int) round($totalHarta * self::KADAR_ZAKAT_MAL / 100)
            : 0;

        return response()->json([
            'data' => [
                'total_harta' => $totalHarta,
                'nishab' => $nishab,
                'wajib_zakat' => $wajibZakat,
                'zakat' => $zakat,
                'persentase' => self::KADAR_ZAKAT_MAL,
            ],
        ]);
    }
}