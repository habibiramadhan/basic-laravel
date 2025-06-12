<?php
// app/Http/Controllers/CatalogController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatBerat;
use App\Models\KategoriAlat;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = AlatBerat::with('kategori')->where('status', 'tersedia');
        
        // Filter by category
        if ($request->kategori) {
            $kategori = KategoriAlat::where('nama_kategori', 'like', '%' . $request->kategori . '%')->first();
            if ($kategori) {
                $query->where('kategori_id', $kategori->id);
            }
        }
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_alat', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sort
        $sort = $request->sort ?? 'nama_alat';
        $direction = $request->direction ?? 'asc';
        $query->orderBy($sort, $direction);
        
        $alat = $query->paginate(12);
        $kategoris = KategoriAlat::all();
        
        return view('catalog.index', compact('alat', 'kategoris'));
    }
    
    public function show($id)
    {
        $alat = AlatBerat::with('kategori')->findOrFail($id);
        $relatedAlat = AlatBerat::where('kategori_id', $alat->kategori_id)
                                ->where('id', '!=', $id)
                                ->where('status', 'tersedia')
                                ->limit(4)
                                ->get();
        
        return view('catalog.show', compact('alat', 'relatedAlat'));
    }
}