<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        $no = 0;
        return view('product', compact(['products', 'no']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => '',
        ]);

        $stock = $request->stock;
        if ($stock == null) {
            $stock = 0;
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $stock,
        ]);

        return redirect()->route('barang.index')->with('success', 'Berhasil tambah barang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => '',
        ]);

        $stock = $request->stock;
        if ($stock == null) {
            $stock = 0;
        }

        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $stock,
        ]);

        return redirect()->route('barang.index')->with('success', 'Berhasil ubah barang');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('barang.index')->with('success', 'Berhasil hapus barang');
    }
}
