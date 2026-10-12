<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Direktori lokasi (BAZNAS / UPZ / warga yang menerima zakat).
 *
 * Kontrak: openapi.yaml#/paths/~1locations, ~1locations~1{id}
 */
class LocationController extends Controller
{
    /**
     * GET /api/locations — daftar paginated + filter (publik).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Location::query()->with('creator');

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('kelurahan', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->query('per_page', 15);
        $perPage = max(1, min(100, $perPage));

        $paginated = $query->latest()->paginate($perPage)->appends($request->query());

        return response()->json([
            'data' => LocationResource::collection($paginated->items()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'last_page' => $paginated->lastPage(),
            ],
            'links' => [
                'first' => $paginated->url(1),
                'last' => $paginated->url($paginated->lastPage()),
                'prev' => $paginated->previousPageUrl(),
                'next' => $paginated->nextPageUrl(),
            ],
        ]);
    }

    /**
     * POST /api/locations — tambah lokasi (admin).
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['is_active'] = $data['is_active'] ?? true;

        $location = Location::create($data);

        return response()->json([
            'message' => 'Lokasi berhasil ditambahkan',
            'data' => new LocationResource($location->load('creator')),
        ], 201);
    }

    /**
     * GET /api/locations/{id} — detail lokasi (publik).
     */
    public function show(Location $location): JsonResponse
    {
        return response()->json([
            'data' => new LocationResource($location->load('creator')),
        ]);
    }

    /**
     * PUT /api/locations/{id} — perbarui lokasi (admin).
     */
    public function update(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $location->update($request->validated());

        return response()->json([
            'message' => 'Lokasi diperbarui',
            'data' => new LocationResource($location->fresh()->load('creator')),
        ]);
    }

    /**
     * DELETE /api/locations/{id} — hapus lokasi (admin).
     */
    public function destroy(Location $location): JsonResponse
    {
        $location->delete();

        return response()->json(['message' => 'Lokasi dihapus']);
    }
}