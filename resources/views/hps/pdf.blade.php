<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export PDF HPS</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            padding: 40px;
        }

        table.header-table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-weight: bold;
        }

        table.header-table td {
            padding: 4px 6px;
        }

        .label {
            color: #00aaff;
            font-weight: bold;
            width: 140px;
        }

        .value {
            color: #00aaff;
            font-weight: bold;
        }

        .right-title {
            font-weight: bold;
            text-align: left;
        }

        .deal {
            background-color: yellow;
            font-weight: bold;
        }

        .hps {
            background-color: #0ccc26;
            font-weight: bold;
        }

        .tgd {
            text-align: center;
            color: #00aaff;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        table.pricelist {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 30px;
        }

        table.pricelist th,
        table.pricelist td {
            border: 1px solid #666;
            padding: 8px;
            vertical-align: middle;
        }

        table.pricelist thead {
            background-color: #d9e1f2;
            font-weight: bold;
            text-align: center;
        }

        table.pricelist tfoot {
            font-weight: bold;
        }

        table.pricelist tfoot td {
            border: 1px solid #666;
            padding: 8px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="label">CARGO NAME</td>
            <td class="value">: {{ $hpsHeader->cargo_name }}</td>
        </tr>
        <tr>
            <td class="label">CONSIGNEE</td>
            <td class="value">: {{ $hpsHeader->consignee }}</td>
            <td class="hps">TARIF HPS</td>
            <td class="hps">{{ number_format($hpsHeader->tpton, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">VESSEL NAME</td>
            <td class="value">: {{ $hpsHeader->vessel_name }}</td>
            <td class="tgd" colspan="2">TON/GANG/DAY: {{ $hpsHeader->tgd }}</td>
        </tr>
        <tr>
            <td class="label">TONASE</td>
            <td class="value">: {{ $hpsHeader->tonase }} Ton</td>
            <td class="text-center value">{{fmod($hpsHeader->hari, 1) == 0 ? $hpsHeader->hari : number_format($hpsHeader->hari, 2) }} HARI</td>
        </tr>
        <tr>
            <td class="label">JUMLAH GANG</td>
            <td class="value">: {{ $hpsHeader->jumlah_gang }} GANG</td>
            <td class="text-center value">{{fmod($hpsHeader->shift, 1) == 0 ? $hpsHeader->shift : number_format($hpsHeader->shift, 2) }} SHIFT</td>
        </tr>
        <tr>
            <td class="label">L/D RATE</td>
            <td class="value">: {{ $hpsHeader->ldrate }} TON/DAY</td>
            <td class="text-center value">{{fmod($hpsHeader->jam, 1) == 0 ? $hpsHeader->jam : number_format($hpsHeader->jam, 2) }} JAM</td>
        </tr>
    </table>

    <table class="pricelist">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jasa</th>
                <th>Qty</th>
                <th>Jumlah Pemakaian</th>
                <th>Tarif</th>
                <th>Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hpsHeader->pricelists as $index => $pl)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pl->service->nama ?? 'N/A' }}</td>
                    <td class="text-right">{{ $pl->qty }}</td>
                    <td class="text-right">{{ $pl->jml_pemakaian }}</td>
                    <td class="text-right">{{ number_format($pl->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $pl->satuan }}</td>
                    <td class="text-right">{{ number_format($pl->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">Total</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">PPH (2%)</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->pph, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">Grand Total</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->grand_total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">Tarif/TON</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->tpton, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">Margin 5%</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->mgn5, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">Margin 10%</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->mgn10, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td class="text-center" style="background-color: #f2f2f2;">Margin 15%</td>
                <td class="text-right" style="background-color: #f2f2f2;">Rp{{ number_format($hpsHeader->mgn15, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
