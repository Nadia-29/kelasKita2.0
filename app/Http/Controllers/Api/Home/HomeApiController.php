<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mentor;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    public function getKelas()
    {
        $kelas = Kelas::with('mentor.user:id_user,first_name,last_name,foto_profil')
            ->select('id_kelas', 'id_mentor', 'nama_kelas', 'description', 'harga', 'thumbnail', 'kategori', 'status_publikasi', 'created_at')
            ->where('status_publikasi', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }

    public function getMentors()
    {
        $mentors = Mentor::with('user:id_user,first_name,last_name,foto_profil')
            ->where('status', 'active')
            ->select('id_mentor', 'id_user', 'keahlian', 'deskripsi_mentor', 'status')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $mentors
        ]);
    }

    public function getReviews()
    {
        $reviews = Review::with([
                'user:id_user,first_name,last_name',
                'kelas:id_kelas,nama_kelas'
            ])
            ->where('bintang', '>=', 4)
            ->select('id_review', 'id_user', 'id_kelas', 'bintang', 'isi_review', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }
}