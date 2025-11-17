<?php

// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // total keluhan per bulan (tahun berjalan)
        $perMonth = Complaint::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // jumlah keluhan berdasarkan status
       $statusCount = Complaint::selectRaw('status, COUNT(*) as total')
    ->groupBy('status')
    ->pluck('total', 'status')
    ->toArray();


        // keluhan terbanyak per kategori
        $topCategories = Complaint::select('category_id', DB::raw('COUNT(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // rata-rata rating kepuasan
        $avgRating = Complaint::whereNotNull('rating')->avg('rating');

        return view('admin.dashboard', compact(
            'perMonth',
            'statusCount',
            'topCategories',
            'avgRating'
        ));
    }
}
