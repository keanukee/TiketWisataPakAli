<?php

namespace App\Http\Controllers;

use App\Models\DestinasiWisata;
use App\Models\KategoriWisata;
use App\Models\PemesananTiket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $totalDestinasi = DestinasiWisata::count();
            $totalKategori = KategoriWisata::count();
            $totalPengunjung = User::where('role', 'pengunjung')->count();
            $totalTiketTerjual = PemesananTiket::where('status_pembayaran', 'lunas')->sum('jumlah_tiket');
            $totalPendapatan = PemesananTiket::where('status_pembayaran', 'lunas')->sum('total_harga');
            $pesananPending = PemesananTiket::where('status_pembayaran', 'pending')->count();
            $pesananTerbaru = PemesananTiket::with(['user', 'destinasi'])->latest()->take(6)->get();

            return view('dashboard.admin', compact(
                'totalDestinasi',
                'totalKategori',
                'totalPengunjung',
                'totalTiketTerjual',
                'totalPendapatan',
                'pesananPending',
                'pesananTerbaru'
            ));
        }

        $destinasiUnggulan = DestinasiWisata::with('kategori')
            ->where('status', 'aktif')
            ->latest()
            ->take(4)
            ->get();

        $pesananSaya = PemesananTiket::with('destinasi')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $totalTiketSaya = PemesananTiket::where('user_id', $user->id)
            ->where('status_pembayaran', 'lunas')
            ->sum('jumlah_tiket');

        return view('dashboard.pengunjung', compact(
            'destinasiUnggulan',
            'pesananSaya',
            'totalTiketSaya'
        ));
    }
}
