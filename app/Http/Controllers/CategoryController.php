<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori dengan fitur pencarian dan paginasi.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Jika ada input pencarian, filter berdasarkan nama kategori
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where('nama', 'like', "%{$keyword}%");
        }

        // Ambil data kategori dengan paginasi (5 per halaman)
        $categories = $query->paginate(5)->appends($request->all());

        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input kategori
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
        ]);

        // Simpan kategori
        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dari satu kategori.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input. Catatan: `unique` sebaiknya ditulis lengkap dengan pengecualian ID saat ini.
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
        ]);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Menghapus kategori, jika belum digunakan di relasi (misal: services).
     */
    public function destroy(Category $category)
    {
        // Cek apakah kategori sudah digunakan pada relasi (misal: service)
        if ($category->services()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori tidak bisa dihapus karena sudah digunakan.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Menyimpan kategori baru dari form service (via AJAX).
     */
    public function storeFromService(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
        ]);

        try {
            // Simpan kategori
            $category = Category::create([
                'nama' => $request->nama,
            ]);

            // Beri respons JSON ke client (digunakan untuk form dinamis seperti modal)
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'category' => [
                    'id' => $category->id,
                    'nama' => $category->nama
                ]
            ]);
        } catch (\Exception $e) {
            // Log error ke file log Laravel
            \Log::error('Error adding category via AJAX: ' . $e->getMessage());

            // Kirim respons error ke client
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori. Terjadi kesalahan server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
