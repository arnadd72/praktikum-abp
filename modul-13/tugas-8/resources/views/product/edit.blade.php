<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('product.index') }}" class="p-2 bg-white rounded-full border shadow-sm hover:shadow-md transition text-gray-500 hover:text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Modifikasi Gudang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-gray-200/60 sm:rounded-[2rem] border border-gray-100">
                
                <div class="bg-gradient-to-r from-blue-900 to-blue-800 p-8 text-white relative overflow-hidden">
                    <div class="absolute top-[-50%] right-[-10%] w-64 h-64 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                    <div class="absolute bottom-[-50%] left-[-10%] w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                    <h3 class="text-2xl font-bold font-heading relative z-10 flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> 
                        Ubah Informasi: {{ $product->name }}
                    </h3>
                    <p class="text-blue-200 mt-2 relative z-10 text-sm">Ubah rincian data harga atau jumlah stok yang sudah usang.</p>
                </div>

                <div class="p-8 sm:p-10 text-gray-900">
                    <form action="{{ route('product.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Nama Barang</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-medium" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Kategori</label>
                                <select name="category" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-medium cursor-pointer" required>
                                    <option value="Beras" {{ $product->category == 'Beras' ? 'selected' : '' }}>Beras</option>
                                    <option value="Minyak Goreng" {{ $product->category == 'Minyak Goreng' ? 'selected' : '' }}>Minyak Goreng</option>
                                    <option value="Gula" {{ $product->category == 'Gula' ? 'selected' : '' }}>Gula</option>
                                    <option value="Telur" {{ $product->category == 'Telur' ? 'selected' : '' }}>Telur</option>
                                    <option value="Tepung" {{ $product->category == 'Tepung' ? 'selected' : '' }}>Tepung</option>
                                    <option value="Lainnya" {{ $product->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Harga (Rp)</label>
                                    <input type="number" name="price" value="{{ $product->price }}" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-bold text-center font-mono" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Stok (Unit)</label>
                                    <input type="number" name="stock" value="{{ $product->stock }}" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-bold text-center font-mono" required>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Deskripsi/Catatan</label>
                                <textarea name="description" rows="4" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:bg-white transition-colors duration-200 p-4 text-gray-900">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <a href="{{ route('product.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 px-6 py-3 transition mr-2">Batal Edit</a>
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                                <svg class="w-5 h-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Selaraskan ke Server
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
