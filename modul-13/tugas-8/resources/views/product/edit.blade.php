<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('product.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="Beras" {{ $product->category == 'Beras' ? 'selected' : '' }}>Beras</option>
                                    <option value="Minyak Goreng" {{ $product->category == 'Minyak Goreng' ? 'selected' : '' }}>Minyak Goreng</option>
                                    <option value="Gula" {{ $product->category == 'Gula' ? 'selected' : '' }}>Gula</option>
                                    <option value="Telur" {{ $product->category == 'Telur' ? 'selected' : '' }}>Telur</option>
                                    <option value="Tepung" {{ $product->category == 'Tepung' ? 'selected' : '' }}>Tepung</option>
                                    <option value="Lainnya" {{ $product->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                <input type="number" name="price" value="{{ $product->price }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stok Barang</label>
                                <input type="number" name="stock" value="{{ $product->stock }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Deskripsi/Catatan</label>
                                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('product.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Produk</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
