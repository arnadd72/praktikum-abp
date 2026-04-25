@extends('template')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if (session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0 text-secondary">Manajemen Produk</h4>
                <a 
                    href="{{ route('products.create') }}" 
                    class="btn btn-primary shadow-sm"
                >
                    + Tambah Data
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <table class="table table-hover table-striped m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga (Rp)</th>
                            <th class="text-center">Aksi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="align-middle">{{ $product->name }}</td>
                            <td class="align-middle">{{ $product->price }}</td>
                            <td class="text-center">
                                <a 
                                    href="{{ route('products.edit', $product->id) }}" 
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Ubah
                                </a>
                                
                                <form 
                                    method="POST" 
                                    action="{{ route('products.destroy', $product->id) }}" 
                                    style="display: inline;" 
                                    onsubmit="return confirm('Hapus permanen produk ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
