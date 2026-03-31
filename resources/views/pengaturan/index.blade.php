@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #C40C0C;">Pengaturan Akun</h2>
        <p class="text-muted">Kelola informasi profil dan keamanan kasir</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                <form action="{{ route('pengaturan.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Data Diri</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Nama Kasir</label>
                            <input type="text" name="name" class="form-control border-0 bg-light" value="{{ $user->name }}" style="border-radius: 10px; padding: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Email</label>
                            <input type="email" name="email" class="form-control border-0 bg-light" value="{{ $user->email }}" style="border-radius: 10px; padding: 12px;">
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <h5 class="fw-bold mb-3"><i class="bi bi-lock me-2"></i>Keamanan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Password Baru</label>
                            <input type="password" name="password" class="form-control border-0 bg-light" placeholder="Isi jika ingin ganti" style="border-radius: 10px; padding: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control border-0 bg-light" placeholder="Ulangi password" style="border-radius: 10px; padding: 12px;">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn text-white w-100 py-3 fw-bold" style="background: linear-gradient(45deg, #FF6500, #C40C0C); border-radius: 12px; border: none;">
                            Update Profil Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 20px;">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    <div style="width: 100px; height: 100px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid #eee;">
                        <i class="bi bi-person-badge text-muted" style="font-size: 45px;"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width: 20px; height: 20px;"></span>
                </div>
                <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                <span class="badge bg-light text-dark mb-3 mt-1">Status: Kasir Aktif</span>

                <div class="bg-light p-3 rounded-3 text-start mb-3">
                    <small class="text-muted d-block">Terakhir Login:</small>
                    <span class="small fw-bold">{{ date('d M Y - H:i') }}</span>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-outline-danger w-100 border-0 py-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Keluar dari Aplikasi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
