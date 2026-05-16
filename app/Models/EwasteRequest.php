<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EwasteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mitra_id',
        'category_id',
        'kategori',
        'berat',
        'alamat',
        'catatan',
        'foto',
        'status',
    ];

    /**
     * Masyarakat yang membuat request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mitra yang mengambil/menangani request
     */
    public function mitra(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    /**
     * Kategori e-waste
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
