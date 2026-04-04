@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h2 class="fw-bold mb-0" style="color: #C40C0C;">Daftar Pesanan</h2>
            <span id="status-update" class="badge bg-light text-muted fw-normal">Update aktif</span>
        </div>

        <div class="row g-3" id="pesanan-container">
            @include('pesanan._list')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchPesanan() {

            if ($('.modal.show').length > 0 || $('.modal-backdrop').length > 0) {
                return;
            }

            $.ajax({
                url: "{{ route('pesanan.fetch') }}",
                type: "GET",
                success: function(data) {
                    $('#pesanan-container').html(data);
                }
            });
        }

        setInterval(fetchPesanan, 10000);

        function hitungKembalian(orderId, totalHarga) {
            let uangBayar = document.getElementById('uang_bayar' + orderId).value;
            let kembalian = uangBayar - totalHarga;

            if (kembalian < 0) kembalian = 0;


            document.getElementById('text_kembalian' + orderId).innerText = 'Rp ' + kembalian.toLocaleString('id-ID');


            document.getElementById('input_kembalian' + orderId).value = kembalian;
        }
    </script>
@endsection
