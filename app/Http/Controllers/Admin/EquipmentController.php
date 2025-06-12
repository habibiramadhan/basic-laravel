<?php
// app/Http/Controllers/Admin/EquipmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlatBerat;
use App\Models\KategoriAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = AlatBerat::with('kategori');
        
        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $alat = $query->orderBy('created_at', 'desc')->paginate(12);
        $kategoris = KategoriAlat::all();
        
        return view('admin.equipment.index', compact('alat', 'kategoris'));
    }
    
    public function create()
    {
        $kategoris = KategoriAlat::all();
        return view('admin.equipment.create', compact('kategoris'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_alat,id',
            'nama_alat' => 'required|string|max:150',
            'merk' => 'required|string|max:100',
            'model' => 'nullable|string|max:100',
            'harga_per_hari' => 'required|numeric|min:0',
            'foto_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'spesifikasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa,maintenance'
        ]);
        
        if ($request->hasFile('foto_utama')) {
            $validated['foto_utama'] = $request->file('foto_utama')->store('alat-berat', 'public');
        }
        
        AlatBerat::create($validated);
        
        return redirect()->route('admin.equipment.index')->with('success', 'Alat berat berhasil ditambahkan');
    }
    
    public function show(AlatBerat $equipment)
    {
        $equipment->load('kategori', 'pemesanan.user');
        return view('admin.equipment.show', compact('equipment'));
    }
    
    public function edit(AlatBerat $equipment)
    {
        $kategoris = KategoriAlat::all();
        return view('admin.equipment.edit', compact('equipment', 'kategoris'));
    }
    
    public function update(Request $request, AlatBerat $equipment)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_alat,id',
            'nama_alat' => 'required|string|max:150',
            'merk' => 'required|string|max:100',
            'model' => 'nullable|string|max:100',
            'harga_per_hari' => 'required|numeric|min:0',
            'foto_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'spesifikasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa,maintenance'
        ]);
        
        if ($request->hasFile('foto_utama')) {
            if ($equipment->foto_utama) {
                Storage::disk('public')->delete($equipment->foto_utama);
            }
            $validated['foto_utama'] = $request->file('foto_utama')->store('alat-berat', 'public');
        }
        
        $equipment->update($validated);
        
        return redirect()->route('admin.equipment.index')->with('success', 'Alat berat berhasil diperbarui');
    }
    
    public function destroy(AlatBerat $equipment)
    {
        if ($equipment->pemesanan()->where('status_pemesanan', 'berlangsung')->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus alat yang sedang disewa');
        }
        
        if ($equipment->foto_utama) {
            Storage::disk('public')->delete($equipment->foto_utama);
        }
        
        $equipment->delete();
        
        return redirect()->route('admin.equipment.index')->with('success', 'Alat berat berhasil dihapus');
    }
    
    public function updateStatus(Request $request, AlatBerat $equipment)
    {
        $validated = $request->validate([
            'status' => 'required|in:tersedia,disewa,maintenance'
        ]);
        
        $equipment->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }
}