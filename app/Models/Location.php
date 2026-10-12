<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'name',
    'address',
    'kelurahan',
    'kecamatan',
    'latitude',
    'longitude',
    'type',
    'description',
    'phone',
    'opening_hours',
    'is_active',
    'created_by',
])]
class Location extends Model
{
    use HasFactory;

    /**
     * Label tipe yang ramah dibaca (dipakai di serialisasi API).
     *
     * @var array<string, string>
     */
    public const TYPE_LABELS = [
        'baznas' => 'BAZNAS',
        'upz' => 'UPZ / Masjid',
        'warga' => 'Warga',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_by' => 'integer',
        ];
    }

    /**
     * Label tipe untuk ditampilkan.
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? ucfirst((string) $this->type);
    }

    /**
     * User yang membuat lokasi ini.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
