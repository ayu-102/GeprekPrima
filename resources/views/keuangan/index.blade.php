@extends('layouts.main')

@section('content')
    <style>
        .card-stat {
            border-radius: 15px;
            transition: transform 0.2s;
            border: none !important;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .bg-light-success {
            background-color: #e8f5e9;
        }

        .bg-light-danger {
            background-color: #ffebee;
        }

        .bg-light-warning {
            background-color: #fff8e1;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .fw-extrabold {
            font-weight: 800;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0" style="color: #C40C0C;">Keuangan</h2>
            <form action="{{ route('keuangan.index') }}" method="GET">
                <input type="date" name="tanggal" class="form-control border-0 shadow-sm px-3" style="border-radius: 10px;"
                    value="{{ request('tanggal', date('Y-m-d')) }}" onchange="this.form.submit()">
            </form>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-stat shadow-sm h-100" style="border-left: 6px solid #28a745 !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-success fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px;">Total Pemasukan</small>
                                <h2 class="fw-bold mb-0 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h2>
                            </div>
                            <div class="icon-box bg-light-success">
                                <i class="bi bi-graph-up-arrow fs-4 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat shadow-sm h-100" style="border-left: 6px solid #C40C0C !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-danger fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px;">Total Transaksi</small>
                                <h2 class="fw-bold mb-0 mt-1">{{ $totalTransaksi }} <small
                                        class="fs-6 fw-normal text-muted">Order</small></h2>
                            </div>
                            <div class="icon-box bg-light-danger">
                                <i class="bi bi-cart-check fs-4 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat shadow-sm h-100" style="border-left: 6px solid #ffc107 !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="flex: 1;">
                                <small class="text-warning fw-bold text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px;">Menu Terlaris</small>
                                <h5 class="fw-bold mb-1 mt-1 text-truncate" style="max-width: 300px;">
                                    {{ $menuTerlaris->menu->nama_menu ?? 'N/A' }}</h5>
                            </div>
                            <div class="icon-box bg-light-warning">
                                <i class="bi bi-star-fill fs-4 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 20px;">
                    <h6 class="fw-bold mb-4">Pendapatan Harian</h6>
                    <div style="height: 300px;">
                        <canvas id="chartPendapatan"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 20px;">
                    <h6 class="fw-bold mb-4">Metode Pembayaran</h6>
                    <div style="height: 220px;">
                        <canvas id="chartMetode"></canvas>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded-3 text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const ctxLine = document.getElementById('chartPendapatan').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: {!! json_encode(
                        $laporanHarian->pluck('tanggal')->map(fn($t) => date('d M', strtotime($t)))->reverse()->values(),
                    ) !!},
                    datasets: [{
                        label: 'Pemasukan',
                        data: {!! json_encode($laporanHarian->pluck('total')->reverse()->values()) !!},
                        borderColor: '#C40C0C',
                        backgroundColor: 'rgba(196, 12, 12, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#C40C0C'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });


            const ctxDonut = document.getElementById('chartMetode').getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($labelsMetode) !!},
                    datasets: [{
                        data: {!! json_encode($dataMetode) !!},
                        backgroundColor: ['#28a745', '#ffc107', '#0dcaf0', '#6610f2'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
