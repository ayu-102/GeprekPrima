@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 ">
        <h2 class="fw-bold mb-0" style="color: #C40C0C;">Riwayat Pesanan</h2>
        <div class="input-group" style="width: 300px;">

            <form action="{{ route('riwayat.index') }}" method="GET" class="mb-4 mt-2">
    <div class="input-group">
        <span class="input-group-text bg-white border-0 shadow-sm" style="border-radius: 10px 0 0 10px;">
            <i class="bi bi-search text-muted"></i>
        </span>
        <input type="text"
            name="search"
            class="form-control border-0 shadow-sm "
            placeholder="Cari nama pembeli..."
            value="{{ request('search') }}"
            style="border-radius: 0 10px 10px 0;">
    </div>
</form>

        </div>
    </div>

    <div class="row g-3">
        @forelse($orders as $order)
        <div class="col-12">
            <div class="card border-0 shadow-sm px-3 py-2" style="border-radius: 15px;">
                <div class="card-body d-flex align-items-center justify-content-between p-2">

                    <div style="width: 150px;">
                        <span class="badge bg-light text-dark mb-1">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
                        <div class="small text-muted">
                            {{ $order->created_at ? $order->created_at->format('d M Y | H:i') : 'Tanggal tidak tersedia' }} WIB
                        </div>
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <h6 class="fw-bold mb-0">{{ $order->nama_pembeli }}</h6>
                            <small class="text-muted">
                                {{ ucfirst(strtolower($order->metode_bayar ?? 'Cash')) }}
                                </small>
                        </div>

                    <div class="ms-3 text-end" style="width: 120px;">
                        <div class="small text-muted">Total</div>
                        <h6 class="fw-bold mb-0" style="color: #FF6500;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h6>
                    </div>

                    <div class="ms-4 d-flex align-items-center">
                        <span class="badge bg-success-subtle text-success me-3">Selesai</span>
                        <a href="{{ route('kasir.pesanan.detail', $order->id) }}" class="btn btn-light rounded-circle shadow-sm">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="opacity-25 mb-3">
            <p class="text-muted">Belum ada riwayat pesanan yang diselesaikan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
