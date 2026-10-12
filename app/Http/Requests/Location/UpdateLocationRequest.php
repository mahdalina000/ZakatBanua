<?php

namespace App\Http\Requests\Location;

/**
 * PUT /locations/{id} memakai skema LocationRequest yang sama dengan
 * create (name, address, type wajib) — lihat openapi.yaml#/paths/~1locations~1{id}.
 */
class UpdateLocationRequest extends StoreLocationRequest
{
}