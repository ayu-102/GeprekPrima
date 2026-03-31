<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Kasir - Geprek Prima</title>
    <style>
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #000;
        }

        .struk {
            width: 45mm;
            margin: 0 auto;
            padding: 10px 2px;
            font-family: 'Courier New', Courier, monospace;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }

        table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }

        .item-row td {
            padding: 2px 0;
        }

        .no-print {
            margin-top: 15px;
            text-align: center;
        }

        @media print {
            .no-print { display: none !important; }

            .struk {
                width: 48mm;
                margin: 0 auto;
                padding-left: 4mm;
                padding-right: 4mm;
            }

            @page {
                margin: 0;
                size: 58mm auto;
            }
        }
    </style>
</head>
<body>
<div class="struk">
    <div class="text-center">
        <b style="font-size: 14px;">GeprekPrima</b><br>
        <span style="font-size: 10px;">Kasir</span>

        <div class="line"></div>

        <div style="font-size: 10px; text-align: left;">
            No   : #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}<br>
            Tgl  : {{ $order->created_at->format('d/m/y H:i') }}<br>
            Plgn : {{ strtoupper($order->nama_pembeli) }}
        </div>
    </div>

    <div class="line"></div>


    <table>
        @foreach($order->orderItems as $item)
        <tr class="item-row">
            <td colspan="2" style="font-size: 11px;">{{ $item->menu->nama_menu }}</td>
        </tr>
        <tr class="item-row">
            <td style="font-size: 10px;">{{ $item->jumlah }} x {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
            <td class="text-right" style="font-size: 10px;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>


    <table style="font-size: 11px;">
    <tr class="bold">
        <td>TOTAL</td>
        <td class="text-right">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Metode:</td>
        <td class="text-right">{{ strtoupper($order->metode_bayar ?? 'CASH') }}</td>
    </tr>


    @if($order->uang_bayar > 0)
    <tr>
        <td>Bayar:</td>
        <td class="text-right">Rp{{ number_format($order->uang_bayar, 0, ',', '.') }}</td>
    </tr>
    <tr class="bold">
        <td>Kembali:</td>
        <td class="text-right">Rp{{ number_format($order->kembalian, 0, ',', '.') }}</td>
    </tr>
    @endif
</table>

    <div class="line"></div>

    <div class="text-center" style="font-size: 10px;">
        <p style="margin: 0;">TERIMA KASIH</p>
        <p style="margin: 0;">Selamat Menikmati!</p>
    </div>

    <div class="no-print">
        <button onclick="window.print()" style="font-size: 11px; padding: 8px 15px; background: #000; color: #fff; border: none; border-radius: 4px; cursor: pointer; width: 100%;">
            PRINT SEKARANG
        </button>
    </div>
</div>

<script>
    window.print();
    window.onafterprint = function() {
        window.close();
    };
</script>

</body>
</html>
