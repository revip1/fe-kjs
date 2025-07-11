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
    public function overview(Request $request)
    {
        $query = HpsHeader::with(['pricelists.service']);

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('cargo_name', 'like', "%{$keyword}%")
                ->orWhere('consignee', 'like', "%{$keyword}%")
                ->orWhere('vessel_name', 'like', "%{$keyword}%");
            });
        }

        $hpsHeaders = $query->get();

        return view('hps.overview', compact('hpsHeaders'));
    }

    public function create()
    {
        $services = Service::all();
        return view('hps.create', compact('services'));
    }

    public function show(HpsHeader $hpsHeader)
    {
        $hpsHeader->load('pricelists.service');

        return view('hps.show', compact('hpsHeader'));
    }

    public function store(Request $request)
    {
        $validatedHeaderData = $request->validate([
            'cargo_name' => 'required|string|max:255',
            'consignee' => 'required|string|max:255',
            'vessel_name' => 'required|string|max:255',
            'tonase' => 'required|string|max:255',
            'jumlah_gang' => 'required|string|max:255',
            'tgd' => 'required|numeric|max:255',
            'ldrate' => 'required|string|max:255',
            'hari' => 'required|string|max:255',
            'shift' => 'required|string|max:255',
            'jam' => 'required|string|max:255',
            'total' => 'numeric|min:0',
            'pph' => 'numeric|min:0',
            'grand_total' => 'numeric|min:0',
            'tpton' => 'numeric|min:0',
            'mgn5' => 'numeric|min:0',
            'mgn10' => 'numeric|min:0',
            'mgn15' => 'numeric|min:0',
        ]);

        
        $validatedPricelists = $request->validate([
            'pricelists' => 'required|array|min:1',
            'pricelists.*.service_id' => 'required|exists:services,id',
            'pricelists.*.qty' => 'required|integer|min:1',
            'pricelists.*.jml_pemakaian' => 'required|integer|min:1',
            'pricelists.*.price' => 'required|numeric|min:0',
            'pricelists.*.satuan' => 'required|string|max:255',
            'pricelists.*.total' => 'required|numeric|min:0',
        ]);

        
        $hpsHeader = HpsHeader::create($validatedHeaderData);

        
        foreach ($request->pricelists as $item) {
            Pricelist::create([
                'hps_header_id' => $hpsHeader->id,
                'service_id' => $item['service_id'],
                'qty' => $item['qty'],
                'jml_pemakaian' => $item['jml_pemakaian'],
                'price' => $item['price'],
                'satuan' => $item['satuan'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('hps.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(HpsHeader $hpsHeader)
    {
        $hpsHeader->load('pricelists.service');
        $services = Service::all();

        return view('hps.edit', compact('hpsHeader', 'services'));
    }

    public function update(Request $request, HpsHeader $hpsHeader)
    {
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

        $hpsHeader->update($validatedHeaderData);

        foreach ($request->pricelists as $item) {
            Pricelist::where('id', $item['id'])->update([
                'qty' => $item['qty'],
                'jml_pemakaian' => $item['jml_pemakaian'],
                'price' => $item['price'],
                'satuan' => $item['satuan'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('hps.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(HpsHeader $hpsHeader)
    {
        $hpsHeader->pricelists()->delete();
        $hpsHeader->delete();

        return redirect()->route('hps.index')->with('success', 'Data HPS berhasil dihapus.');
    }


}