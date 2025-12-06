<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Model untuk respons/tanggapan admin terhadap keluhan
class ComplaintResponse extends Model
{
    protected $fillable = [
        'complaint_id', // ID keluhan
        'admin_id',     // ID admin yang merespons
        'note',         // Catatan tanggapan
        'attachment',   // File lampiran
    ];

    // Relasi ke keluhan yang ditanggapi
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    // Relasi ke admin yang membuat respons
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

