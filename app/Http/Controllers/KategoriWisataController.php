<?php

namespace App\Http\Controllers;

use App\Models\KategoriWisata;
use Illuminate\Http\Request;

class KategoriWisataController extends Controller
{
    public function index()
    {
        $kategori = KategoriWisata::withCount('destinasi')->latest()->get();
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'ikon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['ikon'] = $validated['ikon'] ?: 'bi-compass';
        KategoriWisata::create($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori wisata berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriWisata $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'ikon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori wisata berhasil diperbarui.');
    }

    public function destroy(KategoriWisata $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')
            ->with('success', 'Kategori wisata berhasil dihapus.');
    }
}
