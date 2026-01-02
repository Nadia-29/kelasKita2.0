<?php

namespace App\Http\Controllers\Api\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Materi;

class MateriController extends Controller
{
    // Method untuk menampilkan Tampilan Web (Blade)
    public function indexWeb($id_kelas)
    {
        // Pastikan kelas ada
        $kelas = Kelas::findOrFail($id_kelas);
        
        // Ambil Materi beserta Sub Materinya (Eager Loading)
        // Pastikan di Model Materi ada function subMateri() { return $this->hasMany(...); }
        $materiList = Materi::where('id_kelas', $id_kelas)
            ->with('subMateri') 
            ->orderBy('urutan', 'asc') // Urutkan biar rapi
            ->get();

        return view('mentor.materi.index', compact('kelas', 'materiList'));
    }
}