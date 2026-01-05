<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Keranjang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{public function index()
    {
        $userId = auth()->id() ?? 1;

        $keranjang = Keranjang::with('kelas')->where('id_user', $userId)->get();

        $total = $keranjang->sum(function($item) {
            return $item->kelas->harga ?? 0;
        });

        return view('keranjang', compact('keranjang', 'total'));
    }

    public function tambah(Request $request)
    {
        $userId = auth()->id() ?? 1;

        
        $id_kelas = $request->input('id_kelas') ?? $request->route('id_kelas');

        if (!$id_kelas) {
            return redirect()->back()->with('error', 'ID Kelas tidak ditemukan.');
        }

        $cek = Keranjang::where('id_user', $userId)
            ->where('id_kelas', $id_kelas)
            ->first();

        if ($cek) {
            
            return redirect()->route('keranjang.index')
                ->with('error', 'Kelas ini sudah ada di keranjang Anda!');
        }

        Keranjang::create([
            'id_user' => $userId,
            'id_kelas' => $id_kelas
        ]);

        return redirect()->route('keranjang.index')
            ->with('success', 'Kelas berhasil ditambahkan ke keranjang');
    }

    public function checkout()
    {
        $userId = auth()->id() ?? 1;

        $keranjang = Keranjang::with('kelas:id_kelas,nama_kelas,harga')
            ->where('id_user', $userId)
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang kosong');
        }

        $totalHarga = $keranjang->sum(function ($item) {
            return $item->kelas->harga ?? 0;
        });

        DB::beginTransaction(); // Code ini sekarang aman karena sudah di-import
        try {
            $transaksi = Transaksi::create([
                'id_user' => $userId,
                'total_harga' => $totalHarga,
                'status_pembayaran' => 'pending'
            ]);

            foreach ($keranjang as $item) {
                TransaksiDetail::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_kelas' => $item->id_kelas,
                    'harga_saat_beli' => $item->kelas->harga
                ]);
            }

            Keranjang::where('id_user', $userId)->delete();

            DB::commit();

            return redirect()->route('transaksi.detail', $transaksi->id_transaksi)
                ->with('success', 'Transaksi berhasil dibuat! Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('keranjang.index')
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['transaksiDetail.kelas:id_kelas,nama_kelas,harga'])
            ->where('id_transaksi', $id)
            ->select('id_transaksi', 'id_user', 'total_harga', 'status_pembayaran', 'created_at')
            ->first();

        if (!$transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $transaksi = $transaksi->toArray();

        return view('detail_transaksi', compact('transaksi'));
    }
}