@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 ">
        <div class="d-flex align-items-center">
            <a href="{{ route('riwayat.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h3 class="fw-bold mb-0">Detail #{{ $order->id }}</h3>
        </div>

        <a href="{{ route('pesanan.struk', $order->id) }}" target="_blank" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-printer me-2"></i> Cetak Struk
        </a>
    </div>


    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted mb-1">Nama Pembeli</p>
                    <h5 class="fw-bold">{{ $order->nama_pembeli }}</h5>
                    <p class="text-muted mb-1 mt-3">Metode Pembayaran</p>
                    <span class="badge px-3 py-2"
                        style="background-color: {{ strtolower($order->metode_bayar ?? '') == 'cash' ? '#E67E22' : '#C3110C' }}; color: #ffffff;">
                        {{ strtoupper($order->metode_bayar ?? 'CASH') }}
                    </span>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-1">Waktu Pesan</p>
                    <p class="fw-bold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-muted mb-1 mt-3">Status</p>
                    <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Daftar Menu</h5>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ optional($item->menu)->nama_menu ?? 'Menu Dihapus' }}</td>
                                <td>Rp {{ number_format($item->harga_saat_beli ?? ($item->menu->harga ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-top">
                            <td colspan="3" class="fw-bold text-end">TOTAL BAYAR</td>
                            <td class="text-end fw-bold text-danger fs-5">Rp
                                {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
