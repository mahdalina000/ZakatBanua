<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['price', 'note', 'updated_by'])]
class BerasPrice extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'updated_by' => 'integer',
        ];
    }

    /**
     * User yang terakhir mengubah harga ini.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Harga terkini (record terbaru). Null jika belum ada data.
     */
    public static function current(): ?self
    {
        return static::latest('updated_at')->first();
    }
}
