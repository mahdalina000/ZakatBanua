<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role', 'is_active', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Label role yang ramah dibaca (dipakai di serialisasi API).
     *
     * @var array<string, string>
     */
    public const ROLE_LABELS = [
        'super_admin' => 'Super Admin',
        'admin_baznas' => 'Admin BAZNAS',
        'admin_upz' => 'Admin UPZ',
        'admin' => 'Admin',
        'user' => 'Pengguna',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Label role untuk ditampilkan.
     */
    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[$this->role] ?? ucfirst((string) $this->role);
    }

    /**
     * Apakah user termasuk pengelola (boleh mengubah data).
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_baznas', 'admin_upz', 'admin'], true);
    }

    /**
     * Lokasi yang dibuat oleh user ini.
     */
    public function locations()
    {
        return $this->hasMany(Location::class, 'created_by');
    }

    /**
     * Harga beras yang diubah oleh user ini (audit trail).
     */
    public function berasPrices()
    {
        return $this->hasMany(BerasPrice::class, 'updated_by');
    }
}
