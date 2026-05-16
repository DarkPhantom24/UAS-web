<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'nama_lapak',
        'alamat_lapak',
        'is_approved',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
            'is_approved' => 'boolean',
        ];
    }

    /**
     * Request e-waste yang dibuat oleh masyarakat
     */
    public function ewasteRequests(): HasMany
    {
        return $this->hasMany(EwasteRequest::class, 'user_id');
    }

    /**
     * Order yang ditangani oleh mitra
     */
    public function handledRequests(): HasMany
    {
        return $this->hasMany(EwasteRequest::class, 'mitra_id');
    }
}
