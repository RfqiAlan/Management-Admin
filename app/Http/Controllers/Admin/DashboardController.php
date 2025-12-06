<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

// Controller untuk dashboard admin - menampilkan statistik keluhan
class DashboardController extends Controller
{
    public function index()
    {
        // Total keluhan per bulan
        $perMonth = Complaint::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Jumlah keluhan per status
        $statusCount = Complaint::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Top 5 kategori dengan keluhan terbanyak
        $topCategories = Complaint::select('category_id', DB::raw('COUNT(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Rata-rata rating kepuasan
        $avgRating = Complaint::whereNotNull('rating')->avg('rating');

        return view('admin.dashboard', compact(
            'perMonth',
            'statusCount',
            'topCategories',
            'avgRating'
        ));
    }
}
