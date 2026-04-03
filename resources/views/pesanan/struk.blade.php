<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->id }} - Geprek Prima</title>

    <style>
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            background: #fff;
            color: #000;
            font-family: 'Courier New', Courier, monospace;
        }

        .struk {

            width: 50mm;
            margin: 0 auto;
            padding: 10px 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }

        .item-row td {
            padding: 2px 0;
        }

        .no-print {
            margin-top: 20px;
            text-align: center;
        }


        @media print {
            body {
                background: none;
            }

            .no-print {
                display: none !important;
            }

            .struk {
                width: 100%;
                margin: 0;
                padding: 0;
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
            <b style="font-size: 16px;">Geprek Prima</b><br>
            <span style="font-size: 10px;">Canteen SMKN 4 Tangerang</span>

            <div class="line"></div>

            <div style="font-size: 11px; text-align: left;">
                No : #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}<br>
                Tgl : {{ $order->created_at->format('d/m/y H:i') }}<br>
                Plgn : {{ strtoupper($order->nama_pembeli) }}
            </div>
        </div>

        <div class="line"></div>

        <table>
            @foreach ($order->orderItems as $item)
                <tr class="item-row">
                    <td colspan="2" style="font-size: 12px;">{{ $item->menu->nama_menu }}</td>
                </tr>
                <tr class="item-row">
                    <td style="font-size: 11px;">{{ $item->jumlah }} x
                        {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-size: 11px;">{{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <table style="font-size: 12px;">
            <tr class="bold">
                <td>TOTAL</td>
                <td class="text-right">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Metode:</td>
                <td class="text-right">{{ strtoupper($order->metode_bayar ?? 'CASH') }}</td>
            </tr>

            @if ($order->uang_bayar > 0)
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

        <div class="text-center" style="font-size: 11px;">
            <p style="margin: 0;">TERIMA KASIH</p>
            <p style="margin: 0;">Selamat Menikmati!</p>
        </div>

        <div class="no-print">
            <button onclick="window.print()"
                style="font-size: 12px; padding: 10px; background: #FF6500; color: #fff; border: none; border-radius: 8px; cursor: pointer; width: 100%; font-weight: bold;">
                <i class="bi bi-printer"></i> PRINT STRUK
            </button>
            <br><br>
            <a href="{{ route('menu-user.index') }}"
                style="text-decoration: none; color: #666; font-size: 11px;">Kembali ke Menu</a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }

        window.onafterprint = function() {};
    </script>

</body>

</html>
