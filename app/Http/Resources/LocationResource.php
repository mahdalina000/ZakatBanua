<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Bentuk Location yang dikirim ke API — dipetakan 1:1 dengan
 * openapi.yaml#/components/schemas/Location.
 *
 * @mixin \App\Models\Location
 */
class LocationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'kelurahan' => $this->kelurahan,
            'kecamatan' => $this->kecamatan,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'description' => $this->description,
            'phone' => $this->phone,
            'opening_hours' => $this->opening_hours,
            'is_active' => (bool) $this->is_active,
            'created_by' => $this->created_by,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}