<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\HpsHeader;
use App\Models\Pricelist;

class HpsSeeder extends Seeder
{
    public function run()
    {
        $services = Service::all();

        for ($i = 0; $i <= 15; $i++) {
            $tonase = rand(1, 15);
            $jumlah_gang = rand(1, 4);
            $tgd = rand(1, 5);

            $ldrate = $jumlah_gang * $tgd;
            $hari = $tonase / $ldrate;
            $shift = $hari / 3;
            $jam = $shift * 21;

            // Hitung total HPS
            $total = 0;
            $pricelists = [];

            $totalPricelist = rand(7, 12);

            for ($j = 0; $j < $totalPricelist; $j++) {
                $service = $services->random();
                $qty = rand(1, 10);
                $jml_pemakaian = rand(1, 5);
                $price = rand(10000, 50000);
                $satuan = 'unit';

                $itemTotal = $qty * $jml_pemakaian * $price;
                $total += $itemTotal;

                $pricelists[] = [
                    'service_id' => $service->id,
                    'qty' => $qty,
                    'jml_pemakaian' => $jml_pemakaian,
                    'price' => $price,
                    'satuan' => $satuan,
                    'total' => $itemTotal,
                ];
            }

            $pph = $total * 0.02;
            $grand_total = $total + $pph;
            $tpton = $tonase > 0 ? $grand_total / $tonase : 0;
            $mgn5 = $tpton / 0.95;
            $mgn10 = $tpton / 0.90;
            $mgn15 = $tpton / 0.85;

            $hpsHeader = HpsHeader::create([
                'cargo_name' => 'Cargo ' . ($i + 1),
                'consignee' => 'PT. Contoh ' . ($i + 1),
                'vessel_name' => 'Vessel ' . ($i + 1),
                'tonase' => $tonase,
                'jumlah_gang' => $jumlah_gang,
                'tgd' => $tgd,
                'ldrate' => $ldrate,
                'hari' => $hari,
                'shift' => $shift,
                'jam' => $jam,
                'total' => $total,
                'pph' => $pph,
                'grand_total' => $grand_total,
                'tpton' => $tpton,
                'mgn5' => $mgn5,
                'mgn10' => $mgn10,
                'mgn15' => $mgn15,
            ]);

            foreach ($pricelists as $pl) {
                $pl['hps_header_id'] = $hpsHeader->id;
                Pricelist::create($pl);
            }
        }
    }
}
