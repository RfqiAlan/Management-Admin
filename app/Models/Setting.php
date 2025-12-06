<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk menyimpan pengaturan aplikasi (key-value)
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = false;

    // Ambil nilai setting berdasarkan key
    public static function getValue(string $key, $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    // Simpan/update nilai setting
    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
