<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('product.index') }}" class="p-2 bg-white rounded-full border shadow-sm hover:shadow-md transition text-gray-500 hover:text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Pendaftaran Gudang Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-gray-200/60 sm:rounded-[2rem] border border-gray-100">
                
                <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-8 text-white relative overflow-hidden">
                    <div class="absolute top-[-50%] right-[-10%] w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                    <div class="absolute bottom-[-50%] left-[-10%] w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                    <h3 class="text-2xl font-bold font-heading relative z-10">Formulir Tambah Produk</h3>
                    <p class="text-gray-300 mt-2 relative z-10 text-sm">Pastikan seluruh data barang yang masuk dicatat dengan akurat.</p>
                </div>

                <div class="p-8 sm:p-10 text-gray-900">
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Nama Barang</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <input type="text" name="name" class="pl-11 block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-medium" placeholder="Misal: Beras Pandan Wangi 5kg" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Kategori</label>
                                <select name="category" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-medium cursor-pointer" required>
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    <option value="Beras">Beras</option>
                                    <option value="Minyak Goreng">Minyak Goreng</option>
                                    <option value="Gula">Gula</option>
                                    <option value="Telur">Telur</option>
                                    <option value="Tepung">Tepung</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Harga (Rp)</label>
                                    <input type="number" name="price" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-bold text-center font-mono" placeholder="15000" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Stok (Unit)</label>
                                    <input type="number" name="stock" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 focus:bg-white transition-colors duration-200 py-3 text-gray-900 font-bold text-center font-mono" placeholder="100" required>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Keterangan Ciri / Merek</label>
                                <textarea name="description" rows="4" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 focus:bg-white transition-colors duration-200 p-4 text-gray-900" placeholder="Keterangan tambahan barang sembako. (Boleh kosong)"></textarea>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <a href="{{ route('product.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 px-6 py-3 transition mr-2">Kembali</a>
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/30">
                                <svg class="w-5 h-5 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Rekam Inventaris
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
