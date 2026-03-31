@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #C40C0C;">Daftar Pesanan</h2>
    </div>

    <div class="row g-3">
        @forelse($orders as $order)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-light text-dark mb-1">#{{ $order->id }}</span>
                            <h5 class="fw-bold mb-0">{{ $order->nama_pembeli }}</h5>
                            <small class="text-muted">
                                {{ $order->created_at ? $order->created_at->format('H:i') : '--:--' }} WIB
                            </small>
                        </div>
                        <span class="badge rounded-pill px-3 py-2" style="background-color: #30d9e2; color: #ffffff;">
                            {{ $order->metode_bayar }}
                        </span>
                    </div>

                    <div class="menu-list mb-4">
                        @foreach($order->orderItems as $item)
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $item->jumlah }}x {{ $item->menu->nama_menu }}</span>
                            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach

                        <div class="bg-light p-2 rounded mb-4 mt-2" style="border-left: 4px solid #FF6500;">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Catatan Pesanan:</small>
                            <span class="small fw-medium text-dark">"{{ $order->catatan ?? 'Tidak ada catatan' }}"</span>
                        </div>

                        <hr class="my-2" style="border-style: dashed;">
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span style="color: #FF6500;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-flex">
                        <button class="btn btn-outline-secondary btn-sm flex-grow-1 border-0 bg-light">
                            <i class="bi bi-printer me-1"></i> Cetak
                        </button>
                        <form action="{{ route('order.update-status', $order->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm w-100 border-0" style="background-color: #28a745;">
                                <i class="bi bi-check-lg me-1"></i> Selesai
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="{{ asset('img/no-orders.png') }}" style="width: 150px; opacity: 0.5;">
            <p class="text-muted mt-3">Belum ada pesanan masuk.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
