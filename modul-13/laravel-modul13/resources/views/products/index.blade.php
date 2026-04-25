@extends('template')
@section('title', 'Daftar Produk')

@section('content')
<div class="col-md-10">
    <h3 class="mb-4">Manajemen Produk & Varian</h3>
    <table class="table table-hover table-bordered m-0 bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nama Produk Utama</th>
                <th>Harga (Rp)</th>
                <th>Spesifikasi Varian Terkait</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $d)
            <tr>
                <td class="align-middle fw-bold">{{ $d->name }}</td>
                <td class="align-middle">{{ number_format($d->price, 0, ',', '.') }}</td>
                
                <td class="align-middle">
                    <ul class="mb-0 text-muted" style="font-size: 0.9em; padding-left: 1.2rem;">
                        @foreach ($d->variants as $var)
                            <li class="mb-2">
                                <strong class="text-dark">{{ $var->name }}</strong><br>
                                Processor: {{ $var->processor }} <br>
                                RAM: {{ $var->memory }} | Storage: {{ $var->storage }} <br>
                                <span class="fst-italic">{{ $var->description }}</span>
                            </li>
                        @endforeach
                    </ul>
                </td>
                
                <td class="align-middle text-center">
                    <button class="btn btn-sm btn-primary">Edit</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </td>
            </tr>
            @endforeach
            @if($products->isEmpty())
            <tr>
                <td colspan="4" class="text-center py-4 text-muted">Belum ada data produk tersedia.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
