<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::query();

        // 1. Fitur Search (Cari Text)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kelas', 'like', '%'.$search.'%')
                    ->orWhere('kategori', 'like', '%'.$search.'%')
                    ->orWhere('status_publikasi', 'like', '%'.$search.'%')
                    ->orWhereHas('mentor.user', function ($qUser) use ($search) {
                        $qUser->where('username', 'like', '%'.$search.'%');
                    });
            });
        }

        // 2. Filter Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // 3. Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_publikasi', $request->status);
        }

        // Ambil Data (bisa tambah ->paginate(10) nanti jika data banyak)
        $kelas = $query->get();

        // Ambil daftar kategori unik untuk dropdown filter
        $kategoriUnik = Kelas::select('kategori')->distinct()->pluck('kategori');

        // Ambil daftar status unik
        $statusUnik = Kelas::select('status_publikasi')->distinct()->pluck('status_publikasi');

        return view('admin.pages.kelola-kelas', compact('kelas', 'kategoriUnik', 'statusUnik'));
    }
}
