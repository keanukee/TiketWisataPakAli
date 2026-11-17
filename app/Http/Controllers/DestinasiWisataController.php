<?php

namespace App\Http\Controllers;

use App\Models\DestinasiWisata;
use App\Models\KategoriWisata;
use Illuminate\Http\Request;

class DestinasiWisataController extends Controller
{
    public function index(Request $request)
    {
        $query = DestinasiWisata::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_wisata', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('kode_wisata', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $destinasi = $query->latest()->paginate(8)->withQueryString();
        $kategori = KategoriWisata::all();

        return view('destinasi.index', compact('destinasi', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriWisata::all();
        $nextNumber = DestinasiWisata::count() + 1;
        $kodeOtomatis = 'WPA-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        return view('destinasi.create', compact('kategori', 'kodeOtomatis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_wisata,id',
            'kode_wisata' => 'required|string|max:20|unique:destinasi_wisata,kode_wisata',
            'nama_wisata' => 'required|string|max:150',
            'lokasi' => 'required|string|max:150',
            'harga_tiket' => 'required|numeric|min:0',
            'kuota_harian' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar_url' => 'nullable|url',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (empty($validated['gambar_url'])) {
            $validated['gambar_url'] = 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80';
        }

        DestinasiWisata::create($validated);

        return redirect()->route('destinasi.index')
            ->with('success', 'Destinasi wisata baru berhasil ditambahkan.');
    }

    public function edit(DestinasiWisata $destinasi)
    {
        $kategori = KategoriWisata::all();
        return view('destinasi.edit', compact('destinasi', 'kategori'));
    }

    public function update(Request $request, DestinasiWisata $destinasi)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_wisata,id',
            'kode_wisata' => 'required|string|max:20|unique:destinasi_wisata,kode_wisata,' . $destinasi->id,
            'nama_wisata' => 'required|string|max:150',
            'lokasi' => 'required|string|max:150',
            'harga_tiket' => 'required|numeric|min:0',
            'kuota_harian' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar_url' => 'nullable|url',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $destinasi->update($validated);

        return redirect()->route('destinasi.index')
            ->with('success', 'Data destinasi wisata berhasil diperbarui.');
    }

    public function destroy(DestinasiWisata $destinasi)
    {
        $destinasi->delete();
        return redirect()->route('destinasi.index')
            ->with('success', 'Destinasi wisata berhasil dihapus.');
    }
}
