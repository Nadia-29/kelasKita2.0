<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    private $apiBaseUrl = 'http://127.0.0.1:8000/api';

    public function index()
    {
        $userId = auth()->id() ?? 1;

        // Panggil API (GET)
        $response = Http::get("{$this->apiBaseUrl}/transaksi", [
            'user_id' => $userId
        ]);

        // Cek jika API berhasil memberikan data
        $transaksi = $response->successful() ? $response->json()['data'] : [];

        return view('transaksi', compact('transaksi'));
    }

    public function checkout()
    {
        $userId = auth()->id() ?? 1;

        $response = Http::post("{$this->apiBaseUrl}/transaksi/checkout", [
            'user_id' => $userId
        ]);

        if ($response->successful()) {
            
            $data = $response->json()['data'];
            $transaksiId = $data['id_transaksi'] ?? $data['id']; 

            return redirect()->route('transaksi.detail', $transaksiId)
                ->with('success', 'Transaksi berhasil dibuat! Silakan lanjutkan pembayaran.');
        }

        
        return redirect()->route('keranjang.index')
            ->with('error', $response->json()['message'] ?? 'Gagal membuat transaksi via API');
    }

    public function show($id)
    {
        
        $response = Http::get("{$this->apiBaseUrl}/transaksi/{$id}");

        if (!$response->successful()) {
            abort(404, 'Transaksi tidak ditemukan di API');
        }

        $transaksi = $response->json()['data'];

        return view('detail_transaksi', compact('transaksi'));
    }
}