<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Model utama untuk data keluhan mahasiswa
class Complaint extends Model
{
    protected $fillable = [
        'user_id',       // ID mahasiswa
        'category_id',   // ID kategori keluhan
        'title',         // Judul keluhan
        'description',   // Isi keluhan
        'evidence_file', // File bukti
        'status',        // pending/diproses/selesai/ditolak
        'rating',        // Rating kepuasan (1-5)
        'feedback',      // Feedback dari mahasiswa
    ];

    // Relasi ke mahasiswa pemilik keluhan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kategori keluhan
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke respons admin
    public function responses(): HasMany
    {
        return $this->hasMany(ComplaintResponse::class);
    }
}

