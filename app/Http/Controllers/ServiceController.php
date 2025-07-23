<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Category;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar jasa (services), termasuk kategori terkait.
     * Mendukung pencarian berdasarkan nama jasa atau nama kategori.
     */
    public function index(Request $request)
    {
        // Ambil data jasa dan relasi kategorinya
        $query = Service::with('category');
    
        // Jika ada pencarian, filter berdasarkan nama jasa atau nama kategori
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhereHas('category', function ($q) use ($keyword) {
                      $q->where('nama', 'like', "%{$keyword}%");
                  });
            });
        }
    
        // Paginate hasil pencarian atau seluruh data
        $services = $query->paginate(5)->appends($request->all());
    
        return view('services.index', compact('services'));
    }
    
    /**
     * Menampilkan form untuk menambahkan jasa baru.
     * Juga mengambil semua kategori untuk pilihan dropdown.
     */
    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori
        return view('services.create', compact('categories'));
    }
    
    /**
     * Menyimpan data jasa baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'categories_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);
    
        // Simpan data jasa
        Service::create($request->all());
    
        return redirect()->route('services.index')->with('success', 'Jasa berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan form edit jasa.
     * Data jasa dan semua kategori di-passing ke view.
     */
    public function edit(Service $service)
    {
        $categories = Category::all(); // Ambil semua kategori
        return view('services.edit', compact('service', 'categories'));
    }
    
    /**
     * Memperbarui data jasa yang telah ada.
     */
    public function update(Request $request, Service $service)
    {
        // Validasi input dari form
        $request->validate([
            'categories_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);
    
        // Update data jasa
        $service->update($request->all());
    
        return redirect()->route('services.index')->with('success', 'Jasa berhasil diperbarui.');
    }
    
    /**
     * Menghapus jasa dari database.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Jasa berhasil dihapus.');
    }
}
