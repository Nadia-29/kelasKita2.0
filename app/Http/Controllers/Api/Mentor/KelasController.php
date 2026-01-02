<?php

namespace App\Http\Controllers\Api\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentor;
use App\Models\Kelas;

class KelasController extends Controller
{
    // Method untuk menampilkan Tampilan Web (Blade)
    public function indexWeb()
    {
        $user = auth()->user();
        $mentor = Mentor::where('id_user', $user->id_user)->first();

        if (!$mentor) {
            abort(403, 'Anda bukan Mentor.');
        }
        
        // Ambil semua kelas milik mentor yang sedang login
        $kelasList = Kelas::where('id_mentor', $mentor->id_mentor)->get();

        // Return ke View
        return view('mentor.kelas.index', compact('kelasList'));
    }
}