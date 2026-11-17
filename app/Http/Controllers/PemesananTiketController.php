<?php

namespace App\Http\Controllers;

use App\Models\DestinasiWisata;
use App\Models\KategoriWisata;
use App\Models\PemesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PemesananTiketController extends Controller
{
    public function katalog(Request $request)
    {
        $query = DestinasiWisata::with('kategori')->where('status', 'aktif');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_wisata', 'like', "%{$s}%")
                  ->orWhere('lokasi', 'like', "%{$s}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'termurah') {
                $query->orderBy('harga_tiket', 'asc');
            } elseif ($request->sort === 'termahal') {
                $query->orderBy('harga_tiket', 'desc');
            }
        } else {
            $query->latest();
        }

        $destinasi = $query->get();
        $kategori = KategoriWisata::all();

        return view('pemesanan.katalog', compact('destinasi', 'kategori'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PemesananTiket::with(['user', 'destinasi']);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('kode_booking', 'like', "%{$s}%");
        }

        $pemesanan = $query->latest()->paginate(10)->withQueryString();

        return view('pemesanan.index', compact('pemesanan'));
    }

    public function create(Request $request)
    {
        $destinasiList = DestinasiWisata::where('status', 'aktif')->get();
        $selectedDestinasi = $request->filled('destinasi_id')
            ? DestinasiWisata::find($request->destinasi_id)
            : $destinasiList->first();

        return view('pemesanan.create', compact('destinasiList', 'selectedDestinasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destinasi_id' => 'required|exists:destinasi_wisata,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_tiket' => 'required|integer|min:1|max:50',
            'metode_pembayaran' => 'required|in:QRIS,Transfer VA,E-Wallet,Bayar di Loket',
            'catatan' => 'nullable|string|max:500',
        ]);

        $destinasi = DestinasiWisata::findOrFail($validated['destinasi_id']);
        $sisaKuota = $destinasi->sisaKuotaTanggal($validated['tanggal_kunjungan']);

        if ($validated['jumlah_tiket'] > $sisaKuota) {
            return back()->withErrors([
                'jumlah_tiket' => "Maaf, sisa kuota tiket pada tanggal tersebut hanya tersisa {$sisaKuota} tiket.",
            ])->withInput();
        }

        $kodeBooking = 'TKT-PAALI-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $totalHarga = $destinasi->harga_tiket * $validated['jumlah_tiket'];
        $statusBayar = $request->boolean('bayar_sekarang') ? 'lunas' : 'pending';

        PemesananTiket::create([
            'kode_booking' => $kodeBooking,
            'user_id' => Auth::id(),
            'destinasi_id' => $destinasi->id,
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'jumlah_tiket' => $validated['jumlah_tiket'],
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status_pembayaran' => $statusBayar,
            'status_checkin' => 'belum_checkin',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        $msg = $statusBayar === 'lunas'
            ? "Pembayaran berhasil! E-Ticket {$kodeBooking} sudah aktif dan siap dicetak."
            : "Pesanan {$kodeBooking} berhasil dibuat. Silakan selesaikan pembayaran.";

        return redirect()->route('pemesanan.index')->with('success', $msg);
    }

    public function edit(PemesananTiket $pemesanan)
    {
        if (!Auth::user()->isAdmin() && $pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $destinasiList = DestinasiWisata::where('status', 'aktif')->get();
        return view('pemesanan.edit', compact('pemesanan', 'destinasiList'));
    }

    public function update(Request $request, PemesananTiket $pemesanan)
    {
        if (!Auth::user()->isAdmin() && $pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $rules = [
            'destinasi_id' => 'required|exists:destinasi_wisata,id',
            'tanggal_kunjungan' => 'required|date',
            'jumlah_tiket' => 'required|integer|min:1|max:50',
            'metode_pembayaran' => 'required|in:QRIS,Transfer VA,E-Wallet,Bayar di Loket',
            'catatan' => 'nullable|string|max:500',
        ];

        if (Auth::user()->isAdmin()) {
            $rules['status_pembayaran'] = 'required|in:pending,lunas,dibatalkan';
            $rules['status_checkin'] = 'required|in:belum_checkin,sudah_checkin';
        }

        $validated = $request->validate($rules);
        $destinasi = DestinasiWisata::findOrFail($validated['destinasi_id']);
        $validated['total_harga'] = $destinasi->harga_tiket * $validated['jumlah_tiket'];

        $pemesanan->update($validated);

        return redirect()->route('pemesanan.index')
            ->with('success', "Data pemesanan {$pemesanan->kode_booking} berhasil diperbarui.");
    }

    public function konfirmasiBayar(PemesananTiket $pemesanan)
    {
        if (!Auth::user()->isAdmin() && $pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $pemesanan->update(['status_pembayaran' => 'lunas']);

        return redirect()->route('pemesanan.eticket', $pemesanan->id)
            ->with('success', "Pembayaran {$pemesanan->kode_booking} terkonfirmasi LUNAS! E-Ticket siap digunakan.");
    }

    public function destroy(PemesananTiket $pemesanan)
    {
        if (!Auth::user()->isAdmin() && $pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $kode = $pemesanan->kode_booking;
        $pemesanan->delete();

        return redirect()->route('pemesanan.index')
            ->with('success', "Pemesanan {$kode} berhasil dihapus.");
    }

    public function eticket(PemesananTiket $pemesanan)
    {
        if (!Auth::user()->isAdmin() && $pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $pemesanan->load(['user', 'destinasi.kategori']);
        return view('pemesanan.eticket', compact('pemesanan'));
    }

    public function validasiForm(Request $request)
    {
        $hasilTiket = null;
        if ($request->filled('kode_booking')) {
            $hasilTiket = PemesananTiket::with(['user', 'destinasi'])
                ->where('kode_booking', trim($request->kode_booking))
                ->first();
        }

        return view('pemesanan.validasi', compact('hasilTiket'));
    }

    public function validasiCheckin(PemesananTiket $pemesanan)
    {
        if ($pemesanan->status_pembayaran !== 'lunas') {
            return back()->with('error', 'Tiket belum LUNAS! Tidak dapat melakukan check-in masuk.');
        }

        if ($pemesanan->status_checkin === 'sudah_checkin') {
            return back()->with('error', 'PERINGATAN: E-Ticket ini sudah pernah digunakan untuk check-in sebelumnya!');
        }

        $pemesanan->update(['status_checkin' => 'sudah_checkin']);

        return back()->with('success', "VALIDASI SUKSES! Pengunjung {$pemesanan->user->name} ({$pemesanan->jumlah_tiket} tiket) dipersilakan masuk.");
    }

    public function laporan(Request $request)
    {
        $dari = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->endOfMonth()->toDateString());

        $transaksi = PemesananTiket::with(['user', 'destinasi'])
            ->whereBetween('tanggal_kunjungan', [$dari, $sampai])
            ->where('status_pembayaran', 'lunas')
            ->latest()
            ->get();

        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTiket = $transaksi->sum('jumlah_tiket');

        return view('pemesanan.laporan', compact('transaksi', 'dari', 'sampai', 'totalPendapatan', 'totalTiket'));
    }
}
