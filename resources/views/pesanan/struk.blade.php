<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Kasir - Geprek Prima</title>
    <style>
        html,
        body {
            width: 58mm;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #000;
            font-family: 'Courier New', Courier, monospace;
        }

        .struk {
            width: 58mm;
            margin: 20px auto;
            padding: 10px;
            background: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
        }


        @media screen {
            .struk {
                transform: scale(2);
                transform-origin: top center;
            }
        }

        .struk b {
            font-size: 12px;
        }

        .struk span,
        table {
            font-size: 10px;
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
            margin: 5px 0;
        }

        table {
            width: 100%;
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
            @page {
                size: 58mm auto;
                margin: 0;
            }

            html,
            body {
                width: 58mm !important;
                background: #fff;
            }

            .struk {
                width: 58mm !important;
                margin: 0 !important;
                padding: 2mm !important;
                box-shadow: none !important;
                transform: scale(1) !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="struk">
        <div class="text-center">
            <b>GeprekPrima</b><br>
            <span>Kasir</span>

            <div class="line"></div>

            <div style="text-align: left;">
                No : #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}<br>
                Tgl : {{ $order->created_at->format('d/m/y H:i') }}<br>
                Plgn : {{ strtoupper($order->nama_pembeli) }}
            </div>
        </div>

        <div class="line"></div>

        <table>
            @foreach ($order->orderItems as $item)
                <tr class="item-row">
                    <td colspan="2">{{ $item->menu->nama_menu }}</td>
                </tr>
                <tr class="item-row">
                    <td>{{ $item->jumlah }} x
                        {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <table>
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

        <div class="text-center">
            <p style="margin: 0;">TERIMA KASIH</p>
            <p style="margin: 0;">Selamat Menikmati!</p>
        </div>

        <div class="no-print">
            <button onclick="window.print()"
                style="font-size: 11px; padding: 8px; background: #000; color: #fff; border: none; width: 100%;">
                PRINT SEKARANG
            </button>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 300);
        };

        window.onafterprint = function() {
            window.close();
        };
    </script>

</body>

</html>
