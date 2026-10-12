<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Bentuk BerasPrice yang dikirim ke API — dipetakan 1:1 dengan
 * openapi.yaml#/components/schemas/BerasPrice.
 *
 * @mixin \App\Models\BerasPrice
 */
class BerasPriceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'note' => $this->note,
            'updated_by' => $this->updated_by,
            'updater' => new UserResource($this->whenLoaded('updater')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}