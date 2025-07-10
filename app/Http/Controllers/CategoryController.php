<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
        ]);

        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique',
        ]);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        if($category->services()->exists()){
            return redirect()->route('categories.index')->with('error', 'Kategori Tidak bisa dihapus karna sudah digunakan');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function storeFromService(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama', 
        ]);

        try {
            $category = Category::create([
                'nama' => $request->nama,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'category' => [
                    'id' => $category->id,
                    'nama' => $category->nama
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding category via AJAX: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori. Terjadi kesalahan server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
