@extends('template')

@section('title', 'Form ' . $title . ' Produk')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="m-0">Form {{ $title }} Produk Utama</h5>
                </div>
                <div class="card-body">
                    
                    <form method="POST" action="{{ $route }}">
                        @csrf
                        
                        @if ($method === 'PUT')
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">
                                Nama Produk
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $product->name) }}"
                                autocomplete="off"
                            >
                            @error('name')
                                <div class="invalid-feedback fw-semibold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label fw-bold">
                                Harga Kompetitif (Rupiah)
                            </label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                class="form-control @error('price') is-invalid @enderror" 
                                value="{{ old('price', $product->price) }}"
                            >
                            @error('price')
                                <div class="invalid-feedback fw-semibold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success fw-bold">
                                {{ $title == 'Tambah' ? 'Simpan Baru' : 'Perbarui Data' }}
                            </button>
                            <a 
                                href="{{ route('products.index') }}" 
                                class="btn btn-outline-secondary"
                            >
                                Kembali
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
