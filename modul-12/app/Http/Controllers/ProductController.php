<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        // Mengambil keseluruhan data dari database secara aman
        $products = Product::all();
        
        return view('products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('products.form', [
            'title'   => 'Tambah',
            'product' => new Product(),
            'route'   => route('products.store'),
            'method'  => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        // Proteksi Lapis Pertama: Filter validasi input ekstensif
        $validated = $request->validate([
            'name'  => 'required|string|min:4|max:100',
            'price' => 'required|integer|min:1000000',
        ]);

        try {
            // Proteksi Lapis Kedua: Mass-assignment berbasis fillable
            Product::create($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            // Log ke sistem, jangan melempar SQL trace ke sisi client
            Log::error('Product creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kegagalan sistem penyimpanan.');
        }
    }

    public function edit(Product $product)
    {
        // Data binding Eloquent akan otomatis mencari objek
        // berdasarkan parameter ID pada URI.
        return view('products.form', [
            'title'   => 'Edit',
            'product' => $product,
            'route'   => route('products.update', $product),
            'method'  => 'PUT',
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'  => 'required|string|min:4|max:100',
            'price' => 'required|integer|min:1000000',
        ]);

        try {
            $product->update($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil diperbarui.');
                
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Pembaruan data produk gagal.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil dihapus permanen.');
                
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            
            return redirect()
                ->route('products.index')
                ->with('error', 'Data tidak dapat dihapus.');
        }
    }
}
