<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('product.index') }}" class="p-2 bg-white rounded-full border shadow-sm hover:shadow-md transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Manajemen Inventaris Sembako') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm animate-[pulse_1s_ease-in-out]">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-4 sm:px-0">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center text-2xl shadow-inner border border-white/20">
                        🔖
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Produk</p>
                        <h4 class="text-3xl font-extrabold text-gray-900">{{ count($products) }} <span class="text-sm font-normal text-gray-400">Items</span></h4>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-orange-400 to-red-500 text-white flex items-center justify-center text-2xl shadow-inner border border-white/20">
                        📦
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Stok Minimum</p>
                        <h4 class="text-3xl font-extrabold text-gray-900">{{ $products->min('stock') ?? 0 }} <span class="text-sm font-normal text-gray-400">Unit</span></h4>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-400 to-green-600 text-white flex items-center justify-center text-2xl shadow-inner border border-white/20">
                        💰
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Estimasi Aset</p>
                        <h4 class="text-2xl lg:text-3xl font-bold text-gray-900 tracking-tight">Rp{{ number_format((float)($products->sum(function($p) { return $p->price * $p->stock; })), 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="px-4 sm:px-0">
                <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-2xl border border-gray-100">
                    <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-white">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar Sembako</h3>
                            <p class="text-sm text-gray-500">Update dan pantau inventori gudang.</p>
                        </div>
                        <a href="{{ route('product.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 rounded-xl text-white font-medium hover:bg-gray-800 transition-all shadow-md">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span class="hidden sm:inline">Tambah Data</span>
                        </a>
                    </div>
                    <div class="p-0 text-gray-900 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Nama Barang</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Kategori</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Harga</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Stok</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50/50">Aksi Administrasi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    @forelse ($products as $p)
                                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-emerald-100 to-green-200 flex items-center justify-center text-emerald-700 font-extrabold border border-emerald-300 shadow-sm transition-transform group-hover:scale-110">
                                                        {{ substr($p->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">{{ $p->name }}</div>
                                                        <div class="text-xs text-gray-500 truncate max-w-[150px] sm:max-w-xs">{{ $p->description ?? 'Tidak ada deskripsi' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @php
                                                    $catColors = [
                                                        'Beras' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                        'Minyak Goreng' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                        'Gula' => 'bg-pink-100 text-pink-800 border-pink-200',
                                                        'Telur' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                    ];
                                                    $color = $catColors[$p->category] ?? 'bg-indigo-100 text-indigo-800 border-indigo-200';
                                                @endphp
                                                <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold uppercase tracking-wide rounded-full border {{ $color }} shadow-sm">
                                                    {{ $p->category }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-sm font-bold text-gray-700 font-mono">
                                                Rp {{ number_format($p->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="text-sm font-bold {{ $p->stock < 10 ? 'text-red-500' : 'text-emerald-600' }}">{{ $p->stock }}</span>
                                                    <span class="ml-1 text-[10px] uppercase font-bold text-gray-400">Unit</span>
                                                </div>
                                                @if($p->stock < 10)
                                                    <div class="text-[10px] text-red-500 font-bold uppercase tracking-wider mt-1 animate-pulse flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Limit
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center items-center space-x-2">
                                                    <a href="{{ route('product.edit', $p->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-blue-600 bg-blue-50 border border-transparent rounded-lg hover:bg-blue-600 hover:text-white hover:border-blue-700 transition-all shadow-sm" title="Edit Data">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                        <span class="text-xs font-semibold">Edit</span>
                                                    </a>
                                                    <form action="{{ route('product.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Data akan hilang secara permanen. Yakin ingin menghapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-red-600 bg-red-50 border border-transparent rounded-lg hover:bg-red-600 hover:text-white hover:border-red-700 transition-all shadow-sm" title="Hapus Permanen">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            <span class="text-xs font-semibold">Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 whitespace-nowrap text-center bg-gray-50/30">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 border border-gray-100">
                                                        <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                                    </div>
                                                    <span class="text-gray-500 font-medium">Belum ada inventaris sembako tersimpan.</span>
                                                    <p class="text-xs text-gray-400 mt-1">Gunakan tombol "Tambah Data" untuk mengawali pencatatan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
