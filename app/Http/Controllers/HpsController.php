<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HpsHeader;
use App\Models\Pricelist;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class HpsController extends Controller
{

    public function index(Request $request)
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
    
        $hpsHeaders = $query->paginate(5)->appends($request->all()); // tetap bawa query string saat paginasi
    
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
    
        $hpsHeaders = $query->paginate(5)->appends($request->all()); // tetap bawa query string saat paginasi
    
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
            // 1. Validate Header Data
            $validatedHeaderData = $request->validate([
                'cargo_name' => 'required|string|max:255',
                'consignee' => 'required|string|max:255',
                'vessel_name' => 'required|string|max:255',
                'tonase' => 'required|numeric',
                'tgd' => 'required|numeric',
                'jumlah_gang' => 'required|numeric', 
                'ldrate' => 'required|numeric', 
                'hari' => 'required|numeric', 
                'shift' => 'required|numeric', 
                'jam' => 'required|numeric', 
                'total' => 'required|numeric', 
                'pph' => 'required|numeric',
                'grand_total' => 'required|numeric',
                'tpton' => 'required|numeric',
                'mgn5' => 'required|numeric',
                'mgn10' => 'required|numeric',
                'mgn15' => 'required|numeric',
            ]);

            // 2. Validate Pricelist Data
            $request->validate([
                'pricelists' => 'required|array|min:1',
                'pricelists.*.service_id' => 'required|exists:services,id', // Ensure service_id exists
                'pricelists.*.qty' => 'required|numeric|min:1',
                'pricelists.*.jml_pemakaian' => 'required|numeric|min:1',
                'pricelists.*.price' => 'required|numeric',
                'pricelists.*.satuan' => 'required|string|max:50',
                'pricelists.*.total' => 'required|numeric',
                'pricelists.*.id' => 'nullable|exists:pricelists,id', // 'id' is optional and must exist if provided
            ]);

            
            DB::transaction(function () use ($request, $hpsHeader, $validatedHeaderData) {
                // Update HPS Header
                $hpsHeader->update($validatedHeaderData);

                $existingPricelistIds = $hpsHeader->pricelists->pluck('id')->toArray();
                $submittedPricelistIds = [];

                foreach ($request->pricelists as $item) {
                    $pricelistData = [
                        'hps_header_id' => $hpsHeader->id,
                        'service_id' => $item['service_id'],
                        'qty' => $item['qty'],
                        'jml_pemakaian' => $item['jml_pemakaian'],
                        'price' => $item['price'],
                        'satuan' => $item['satuan'],
                        'total' => $item['total'],
                    ];

                    if (isset($item['id']) && $item['id']) {
                        Pricelist::where('id', $item['id'])->update($pricelistData);
                        $submittedPricelistIds[] = $item['id'];
                    } else {
                        Pricelist::create($pricelistData);
                    }
                }

                $pricelistsToDelete = array_diff($existingPricelistIds, $submittedPricelistIds);
                if (!empty($pricelistsToDelete)) {
                    Pricelist::whereIn('id', $pricelistsToDelete)->delete();
                }
            });

            return redirect()->route('hps.index')->with('success', 'Data HPS berhasil diperbarui.');
        }

    public function destroy(HpsHeader $hpsHeader)
    {
        $hpsHeader->pricelists()->delete();
        $hpsHeader->delete();

        return redirect()->route('hps.index')->with('success', 'Data HPS berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $hpsHeader = HpsHeader::with('pricelists.service')->findOrFail($id);
        
        $pdf = Pdf::loadView('hps.pdf', compact('hpsHeader'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('HPS_'.$hpsHeader->cargo_name.'.pdf');
    }


}