<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HpsHeader;
use App\Models\Pricelist;
use App\Models\Service;

class HpsController extends Controller
{

    public function index()
    {
        $hpsHeaders = HpsHeader::with(['pricelists.service'])->get();

        return view('hps.index', compact('hpsHeaders'));
    }
    public function overview()
    {
        $hpsHeaders = HpsHeader::with(['pricelists.service'])->get();

        return view('hps.overview', compact('hpsHeaders'));
    }

    public function create()
    {
        $services = Service::all(); // Fetch services for pricelist dropdown
        return view('hps.create', compact('services'));
    }

    public function store(Request $request)
    {
        // Validasi HPS Header
        $validatedHeaderData = $request->validate([
            'cargo_name' => 'required|string|max:255',
            'consignee' => 'required|string|max:255',
            'vessel_name' => 'required|string|max:255',
            'tonase' => 'required|string|max:255',
            'jumlah_gang' => 'required|string|max:255',
            'ldrate' => 'required|string|max:255',
            'hari' => 'required|string|max:255',
            'shift' => 'required|string|max:255',
            'jam' => 'required|string|max:255',
        ]);

        // Validasi semua data pricelist yang dikirim dalam array
        $validatedPricelists = $request->validate([
            'pricelists' => 'required|array|min:1',
            'pricelists.*.service_id' => 'required|exists:services,id',
            'pricelists.*.nama' => 'required|string|max:255',
            'pricelists.*.qty' => 'required|integer|min:1',
            'pricelists.*.jml_pemakaian' => 'required|integer|min:1',
            'pricelists.*.price' => 'required|numeric|min:0',
            'pricelists.*.satuan' => 'required|string|max:255',
            'pricelists.*.total' => 'required|numeric|min:0',
        ]);

        // Simpan HPS Header ke database
        $hpsHeader = HpsHeader::create($validatedHeaderData);

        // Simpan masing-masing pricelist, dikaitkan ke HPS Header jika ada relasi
        foreach ($request->pricelists as $item) {
            Pricelist::create([
                'hps_header_id' => $hpsHeader->id,
                'service_id' => $item['service_id'],
                'nama' => $item['nama'],
                'qty' => $item['qty'],
                'jml_pemakaian' => $item['jml_pemakaian'],
                'price' => $item['price'],
                'satuan' => $item['satuan'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('hps.overview')->with('success', 'Data berhasil disimpan.');
    }

}