@extends('layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 ">
            <div>
                <h2 class="fw-bold mb-0" style="color: #C40C0C">Menu Makanan</h2>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <button class="btn btn-primary rounded-pill px-4" style="background-color: #FF6500; border: none;"
                data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
                <i class="fa-solid fa-plus me-2"></i> Tambah Menu
            </button>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($menus as $m)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm"
                        style="border-radius: 15px; overflow: hidden; min-height: 150px;">
                        <div class="row g-0 h-100">
                            <div class="col-5">
                                <div class="h-100 w-100"
                                    style="position: relative; min-height: 150px; background-color: #f8f9fa;">
                                    <img src="{{ $m->foto && file_exists(public_path('storage/' . $m->foto))
                                        ? asset('storage/' . $m->foto)
                                        : asset('img/' . ($m->foto ?: 'es.png')) }}"
                                        class="card-img-top" alt="{{ $m->nama_menu }}" class="img-fluid"
                                        style="object-fit: cover; width: 100%; height: 100%; position: absolute; {{ $m->stok <= 0 ? 'filter: grayscale(1);' : '' }}">

                                    @if ($m->stok <= 0)
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                            style="background: rgba(0, 0, 0, 0.4); color: white;">
                                            <span class="fw-bold px-2 py-1"
                                                style="background: #C40C0C; border-radius: 5px; font-size: 0.8rem;">HABIS</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div
                                class="col-7 d-flex flex-column justify-content-between p-3 {{ $m->stok <= 0 ? 'bg-light' : '' }}">
                                <div>
                                    <h6 class="fw-bold mb-1 {{ $m->stok <= 0 ? 'text-muted' : 'text-dark' }}">
                                        {{ $m->nama_menu }}</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.8rem;">{{ $m->kategori ?? 'Umum' }}</p>
                                    <h6 class="fw-bold mt-2 mb-1" style="color: #FF6500;">Rp
                                        {{ number_format($m->harga, 0, ',', '.') }}</h6>

                                    <p class="mb-0 {{ $m->stok <= 5 ? 'text-danger fw-bold' : 'text-muted' }}"
                                        style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-box-open me-1"></i> Stok: {{ $m->stok }}
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" {{ $m->stok > 0 ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label small"
                                            style="font-size: 0.75rem;">{{ $m->stok > 0 ? 'Tersedia' : 'Habis' }}</label>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm text-secondary p-1" data-bs-toggle="modal"
                                            data-bs-target="#modalEditMenu{{ $m->id }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <form action="{{ route('menu.destroy', $m->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin mau hapus menu {{ $m->nama_menu }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger p-1">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalEditMenu{{ $m->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 20px; border: none;">
                            <div class="modal-header border-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold">Edit Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('menu.update', $m->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-body px-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Ganti Foto (Opsional)</label>
                                        <input type="file" name="foto" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Nama Menu</label>
                                        <input type="text" name="nama_menu" class="form-control"
                                            value="{{ $m->nama_menu }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label small fw-bold">Harga (Rp)</label>
                                            <input type="number" name="harga" class="form-control"
                                                value="{{ $m->harga }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label small fw-bold">Stok</label>
                                            <input type="number" name="stok" class="form-control"
                                                value="{{ $m->stok }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Kategori</label>
                                        <select name="kategori" class="form-select">
                                            <option value="Makanan" {{ $m->kategori == 'Makanan' ? 'selected' : '' }}>
                                                Makanan</option>
                                            <option value="Minuman" {{ $m->kategori == 'Minuman' ? 'selected' : '' }}>
                                                Minuman</option>
                                            <option value="Snack" {{ $m->kategori == 'Snack' ? 'selected' : '' }}>Snack
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4"
                                        style="background-color: #FF6500; border: none;">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="modalTambahMenu" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #C40C0C;">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body px-4">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Foto Menu</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Snack">Snack</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Harga</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Stok Awal</label>
                                <input type="number" name="stok" class="form-control" value="0" required>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary rounded-pill px-4"
                            style="background-color: #FF6500; border: none;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
