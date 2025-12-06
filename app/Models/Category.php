<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Model untuk kategori keluhan
class Category extends Model
{
    protected $fillable = ['name', 'description'];

    // Relasi: satu kategori punya banyak keluhan
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
}
