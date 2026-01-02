<?php

namespace App\Http\Controllers\Api\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentor;
use App\Models\Kelas;
use App\Models\TransaksiDetail;
use App\Models\Review;

class MentorDashboardController extends Controller
{
    // Method untuk menampilkan Tampilan Web (Blade)
    public function indexWeb()
    {
        $user = auth()->user();
        $mentor = Mentor::where('id_user', $user->id_user)->first();

        if (!$mentor) {
            abort(403, 'Akses Ditolak. Anda bukan Mentor.');
        }

        // --- 1. Hitung Statistik ---
        
        // A. Total Kelas
        $totalKelas = Kelas::where('id_mentor', $mentor->id_mentor)->count();

        // B. Ambil ID Kelas milik mentor ini (untuk query selanjutnya)
        $kelasIds = Kelas::where('id_mentor', $mentor->id_mentor)->pluck('id_kelas');

        // C. Total Siswa (Unik & Status Paid)
        $totalSiswa = TransaksiDetail::whereIn('id_kelas', $kelasIds)
            ->whereHas('transaksi', function($q) { 
                $q->where('status', 'paid'); 
            })
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'transaksi_detail.id_transaksi')
            ->distinct('transaksi.id_user')
            ->count('transaksi.id_user');

        // D. Total Pendapatan
        $totalPendapatan = TransaksiDetail::whereIn('id_kelas', $kelasIds)
            ->whereHas('transaksi', function($q) { 
                $q->where('status', 'paid'); 
            })
            ->sum('harga_saat_beli');

        // E. Rata-rata Rating
        $avgRating = Review::whereIn('id_kelas', $kelasIds)->avg('bintang');

        // F. Transaksi Terakhir (Untuk tabel di dashboard)
        $recentActivities = TransaksiDetail::whereIn('id_kelas', $kelasIds)
            ->whereHas('transaksi', function($q) { $q->where('status', 'paid'); })
            ->with(['transaksi.user', 'kelas'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // --- 2. Lempar data ke View ---
        return view('mentor.dashboard', compact(
            'totalKelas', 
            'totalSiswa', 
            'totalPendapatan', 
            'avgRating', 
            'recentActivities'
        ));
    }
}