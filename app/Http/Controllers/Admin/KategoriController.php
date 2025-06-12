<?php
// app/Http/Controllers/Admin/KategoriController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriAlat;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriAlat::withCount('alatBerat');
        
        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }
        
        $kategoris = $query->orderBy('nama_kategori')->paginate(10);
        
        return view('admin.kategori.index', compact('kategoris'));
    }
    
    public function create()
    {
        return view('admin.kategori.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_alat,nama_kategori',
            'deskripsi' => 'nullable|string|max:500'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada, gunakan nama lain',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter'
        ]);
        
        KategoriAlat::create($validated);
        
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function show(KategoriAlat $kategori)
    {
        $kategori->load(['alatBerat' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('admin.kategori.show', compact('kategori'));
    }
    
    public function edit(KategoriAlat $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }
    
    public function update(Request $request, KategoriAlat $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_alat,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:500'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada, gunakan nama lain',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter'
        ]);
        
        $kategori->update($validated);
        
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }
    
    public function destroy(KategoriAlat $kategori)
    {
        if ($kategori->alatBerat()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki alat berat');
        }
        
        $kategori->delete();
        
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}