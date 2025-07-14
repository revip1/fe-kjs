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

        .header-info {
            margin-bottom: 20px;
            color: #00aaff;
            font-weight: bold;
            width: 50%;
            float: left;
        }

        .header-row {
            margin-bottom: 6px;
            clear: both;
        }

        .header-label {
            display: inline-block;
            width: 140px;
        }

        .header-value {
            display: inline-block;
        }

        .tarif-wrapper {
            float: right;
            width: 240px;
            text-align: center;
            border:none
        }

        .tarif-header {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 2px;
            border:none
        }

        .tarif-header th, .tarif-header td {
            padding: 2px 5px;
            border: 1px solid #000;
            text-align: left;
            border:none
        }

        .deal {
            background-color: yellow;
        }

        .hps {
            background-color: lightgreen;
        }

        .ton-gang-day {
            color: #00aaff;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 6px;
        }

        .hari-shift-jam {
            font-size: 12px;
            font-weight: bold;
            color: #00aaff;
            margin-top: 4px;
            margin-right: 110px; 
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 4px 0px;
        }

        /* .hari-shift-jam .row {
            display: grid;
            justify-content: space-between;
            margin-bottom: 4px;
            margin-left: 3px;
        } */

        .hari-shift-jam .label{
            color: #00aaff;
            text-align: right;
            padding-right: 5px;
        }
       
        .hari-shift-jam .value {
            color: #00aaff;
            text-align: left;
        }

        table.pricelist {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            font-size: 14px;
            clear: both;
        }

        table.pricelist th, table.pricelist td {
            border: 1px solid #999;
            padding: 10px;
        }

        table.pricelist thead {
            background-color: #eee;
        }

        .summary-table {
            width: 320px;
            margin-left: auto;
            margin-top: 25px;
            border-collapse: collapse;
            font-size: 14px;
        }

        .summary-table th,
        .summary-table td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: left;
        }

        .summary-table th {
            background-color: #f5f5f5;
            width: 60%;
        }
    </style>
</head>
<body>

    <div class="header-info">
        <div class="header-row">
            <div class="header-label">CARGO NAME :</div>
            <div class="header-value">{{ $hpsHeader->cargo_name }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">CONSIGNEE :</div>
            <div class="header-value">{{ $hpsHeader->consignee }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">VESSEL NAME :</div>
            <div class="header-value">{{ $hpsHeader->vessel_name }}</div>
        </div>
        <div class="header-row">
            <div class="header-label">TONASE :</div>
            <div class="header-value">{{ $hpsHeader->tonase }} Ton</div>
        </div>
        <div class="header-row">
            <div class="header-label">JUMLAH GANG :</div>
            <div class="header-value">{{ $hpsHeader->jumlah_gang }} GANG</div>
        </div>
        <div class="header-row">
            <div class="header-label">L/D RATE :</div>
            <div class="header-value">{{ $hpsHeader->ldrate }} TON/DAY</div>
        </div>
    </div>
    <div class="tarif-wrapper">
        <table class="tarif-header">
            <tr class="hps">
                <th>TARIF HPS</th>
                <td>{{ ($hpsHeader->tpton) }}</td>
            </tr>
        </table>

        <div class="ton-gang-day">
            TON/GANG/DAY: {{ ($hpsHeader->tgd) }}
        </div>

        <div class="hari-shift-jam">
            <div class="row">
                <span class="value">{{ ($hpsHeader->hari) }}</span>
                <span class="label">HARI</span>
            </div>
            <div class="row">
                <span class="value">{{ ($hpsHeader->shift) }}</span>
                <span class="label">SHIFT</span>
            </div>
            <div class="row">
            <span class="value">{{ ($hpsHeader->jam) }}</span>
                <span class="label">JAM</span>
            </div>
        </div>
    </div>

    <div style="clear: both;"></div>

    <!-- Pricelist -->
    <h3>Pricelist</h3>
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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pl->service->nama ?? 'N/A' }}</td>
                    <td>{{ $pl->qty }}</td>
                    <td>{{ $pl->jml_pemakaian }}</td>
                    <td>{{ number_format($pl->price, 0, ',', '.') }}</td>
                    <td>{{ $pl->satuan }}</td>
                    <td>{{ number_format($pl->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SUMMARY --}}
    <table class="summary-table">
        <tr>
            <th>Total</th>
            <td>Rp{{ number_format($hpsHeader->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>PPH (2%)</th>
            <td>Rp{{ number_format($hpsHeader->pph, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td>Rp{{ number_format($hpsHeader->grand_total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Margin 5%</th>
            <td>Rp{{ number_format($hpsHeader->mgn5, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Margin 10%</th>
            <td>Rp{{ number_format($hpsHeader->mgn10, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Margin 15%</th>
            <td>Rp{{ number_format($hpsHeader->mgn15, 0, ',', '.') }}</td>
        </tr>
    </table>

</body>
</html>
