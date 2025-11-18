<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Fasilitas Fisik
            'Fasilitas Kelas (AC/Proyektor/Kursi)',
            'Fasilitas Umum (Toilet/Kantin/Masjid)',
            'Fasilitas Parkiran',
            
            // IT & Jaringan
            'Jaringan Internet / WiFi Kampus',
            'Website & Portal Akademik (SIAKAD)',
            'Laboratorium Komputer',

            // Akademik & Pengajaran
            'Kinerja Dosen & Pengajaran',
            'Jadwal Kuliah & Ujian',
            'Pelayanan Perpustakaan',

            // Administrasi
            'Pelayanan Tata Usaha (TU)',
            'Administrasi Keuangan / UKT',
            'Layanan Kemahasiswaan',

            // Lingkungan & Keamanan
            'Kebersihan Lingkungan Kampus',
            'Keamanan & Ketertiban (Satpam)',
            'Lainnya'
        ];

        foreach ($categories as $name) {
            // updateOrCreate digunakan agar tidak ada duplikat jika dijalankan berulang
            Category::updateOrCreate(['name' => $name]);
        }
    }
}