<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Category;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('category');
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhereHas('category', function ($q) use ($keyword) {
                      $q->where('nama', 'like', "%{$keyword}%");
                  });
            });
        }
    
        $services = $query->paginate(5)->appends($request->all());
    
        return view('services.index', compact('services'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'categories_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);
    
        Service::create($request->all());
    
        return redirect()->route('services.index')->with('success', 'Jasa berhasil ditambahkan.');
    }
    
    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('services.edit', compact('service', 'categories'));
    }
    
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'categories_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);
    
        $service->update($request->all());
    
        return redirect()->route('services.index')->with('success', 'Jasa berhasil diperbarui.');
    }
    
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Jasa berhasil dihapus.');
    }
}
