<style>
    .img-zoomable.zoomed {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-height: 90vh !important;
        max-width: 90vw !important;
        z-index: 9999;
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
        cursor: zoom-out !important;
    }

    .bukti-wrapper:hover .btn-zoom-hint {
        opacity: 1;
    }

    .btn-zoom-hint {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 0.7rem;
        opacity: 0;
        transition: 0.3s;
        pointer-events: none;
    }
</style>

<div class="row">
    @forelse($orders as $order)
        <div class="col-12 col-md-6 col-lg-4 mb-4" style="max-width: 530px;">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; height: 100%;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-light text-dark mb-1">#{{ $order->id }}</span>
                            <h5 class="fw-bold mb-0">{{ $order->nama_pembeli }}</h5>
                            <small class="text-muted">
                                {{ $order->created_at ? $order->created_at->format('H:i') : '--:--' }} WIB
                            </small>
                        </div>
                        <span class="badge rounded-pill px-3 py-2"
                            style="background-color: {{ strtolower($order->metode_bayar ?? '') == 'cash' ? '#E67E22' : '#C3110C' }}; color: #ffffff;">
                            {{ strtoupper($order->metode_bayar ?? 'CASH') }}
                        </span>
                    </div>

                    <div class="menu-list mb-4">
                        @foreach ($order->orderItems as $item)
                            <div class="d-flex justify-content-between small mb-1">
                                <span>{{ $item->jumlah }}x
                                    {{ optional($item->menu)->nama_menu ?? 'Menu Dihapus' }}</span>
                                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach

                        <div class="bg-light p-2 rounded mb-4 mt-2" style="border-left: 4px solid #FF6500;">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Catatan:</small>
                            <span
                                class="small fw-medium text-dark">"{{ $order->catatan ?? 'Tidak ada catatan' }}"</span>
                        </div>

                        <hr class="my-2" style="border-style: dashed;">
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span style="color: #FF6500;">Rp
                                {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('pesanan.struk', $order->id) }}" target="_blank"
                            class="btn btn-outline-secondary btn-sm flex-grow-1 border-0 bg-light text-muted d-flex align-items-center justify-content-center"
                            style="height: 40px; border-radius: 10px;">
                            <i class="bi bi-printer me-1"></i> Cetak
                        </a>

                        @if ($order->status !== 'lunas' && $order->status !== 'dibatalkan')
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="flex-grow-1"
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit"
                                    class="btn btn-danger btn-sm w-100 border-0 d-flex align-items-center justify-content-center"
                                    style="height: 40px; border-radius: 10px;">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                            </form>
                        @endif

                        <button type="button"
                            class="btn btn-success btn-sm flex-grow-1 border-0 d-flex align-items-center justify-content-center"
                            style="background-color: #28a745; height: 40px; border-radius: 10px;" data-bs-toggle="modal"
                            data-bs-target="#modalBayar{{ $order->id }}">
                            <i class="bi bi-check-lg me-1"></i> Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalBayar{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 20px; border: none;">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Verifikasi Pembayaran #{{ $order->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('kasir.selesai', $order->id) }}" method="POST" target="_blank"
                        onsubmit="setTimeout(function(){ window.location.reload(); }, 1000);">
                        @csrf
                        <input type="hidden" name="metode_bayar" value="{{ $order->metode_bayar }}">

                        <div class="modal-body p-4 text-center">
                            <div class="mb-4 p-3"
                                style="border: 2px dashed #ddd; border-radius: 15px; background-color: #fcfcfc;">

                                @if (strtolower($order->metode_bayar) !== 'cash')
                                    <p class="small fw-bold text-muted mb-2 text-uppercase">Bukti Transfer & Data
                                        Pengirim:</p>

                                    @if ($order->bukti_pembayaran)
                                        <div class="bukti-wrapper position-relative d-inline-block">
                                            <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                                                class="img-fluid rounded border img-zoomable"
                                                style="max-height: 200px; cursor: zoom-in;" onclick="toggleZoom(this)">
                                            <span class="btn-zoom-hint"><i class="bi bi-search"></i> Perbesar</span>
                                        </div>

                                        <div class="mt-3 p-3 bg-white border rounded text-start shadow-sm">
                                            <div class="row">
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Nama
                                                        Pengirim:</small>
                                                    <span
                                                        class="fw-bold text-primary">{{ $order->nama_pengirim ?? 'Tidak diisi' }}</span>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted d-block" style="font-size: 0.7rem;">ID
                                                        Transaksi:</small>
                                                    <span
                                                        class="fw-bold text-dark">{{ $order->id_transaksi ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="mt-1 pt-2 border-top">
                                                <small class="text-danger italic" style="font-size: 0.65rem;">
                                                    *Cocokkan nama di atas dengan mutasi bank Anda.
                                                </small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="py-4">
                                            <i class="bi bi-exclamation-octagon text-danger"
                                                style="font-size: 2rem;"></i>
                                            <p class="text-danger small fw-bold mb-0">USER BELUM UPLOAD BUKTI</p>
                                        </div>
                                    @endif
                                @else
                                    <i class="bi bi-cash-stack text-success" style="font-size: 2.5rem;"></i>
                                    <p class="small fw-bold text-muted mt-2 mb-0">PEMBAYARAN TUNAI (CASH)</p>
                                @endif
                            </div>

                            <div class="bg-light p-3 rounded-3 mb-4">
                                <small class="text-muted d-block">Total Tagihan:</small>
                                <h3 class="fw-bold text-danger mb-0">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</h3>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label small fw-bold">Uang Diterima</label>
                                <input type="number" name="uang_bayar" id="uang_bayar{{ $order->id }}"
                                    class="form-control form-control-lg border-0 bg-light shadow-none"
                                    {{ strtolower($order->metode_bayar) !== 'cash' ? 'value=' . $order->total_harga . ' readonly' : '' }}
                                    required
                                    oninput="hitungKembalian('{{ $order->id }}', '{{ $order->total_harga }}')">
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <label class="small fw-bold text-muted">Kembalian:</label>
                                <h4 class="fw-bold text-success mb-0" id="text_kembalian{{ $order->id }}">Rp 0
                                </h4>
                                <input type="hidden" name="kembalian" id="input_kembalian{{ $order->id }}"
                                    value="0">
                            </div>
                        </div>

                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm"
                                style="background-color: #FF6500; border: none; border-radius: 12px;">
                                Konfirmasi & Cetak Struk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted mt-3">Belum ada pesanan masuk hari ini.</p>
        </div>
    @endforelse
</div>

<script>
    function toggleZoom(img) {
        let backdrop = document.querySelector('.zoom-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'zoom-backdrop';
            document.body.appendChild(backdrop);
            backdrop.onclick = function() {
                const zoomedImg = document.querySelector('.img-zoomable.zoomed');
                if (zoomedImg) zoomedImg.classList.remove('zoomed');
                backdrop.style.display = 'none';
            };
        }

        if (img.classList.contains('zoomed')) {
            img.classList.remove('zoomed');
            backdrop.style.display = 'none';
        } else {
            img.classList.add('zoomed');
            backdrop.style.display = 'block';
        }
    }

    function hitungKembalian(id, total) {
        const bayar = document.getElementById('uang_bayar' + id).value;
        const kembalian = bayar - total;
        const textKembalian = document.getElementById('text_kembalian' + id);
        const inputKembalian = document.getElementById('input_kembalian' + id);

        if (kembalian >= 0) {
            textKembalian.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembalian);
            inputKembalian.value = kembalian;
            textKembalian.classList.replace('text-danger', 'text-success');
        } else {
            textKembalian.innerText = 'Kurang: Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(kembalian));
            textKembalian.classList.replace('text-success', 'text-danger');
            inputKembalian.value = 0;
        }
    }
</script>
