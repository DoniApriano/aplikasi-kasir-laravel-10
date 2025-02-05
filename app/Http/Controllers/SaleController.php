<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $month = date('m');
        $day = date('d');
        $year = date('Y');

        $today = $year . '-' . $month . '-' . $day;
        $customers = Customer::latest()->get();
        $sales = Sale::latest()->get();
        $sales_detail = SaleDetail::latest()->get();
        $no = 0;
        return view('transaction', compact(['customers', 'today', 'sales', 'sales_detail', 'no']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'customer_id' => 'required',
        ]);

        $sale = Sale::create([
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'total_price' => 0,
        ]);

        $sale_id = $sale->id;

        return redirect()->route('transaksi.show', $sale_id);
    }

    public function show($id)
    {
        $sales_detail = SaleDetail::where('sale_id', $id)->get();
        $sale = Sale::where('id', $id)->with('customer')->first();
        $products = Product::latest()->get();
        $no = 0;

        return view('transaction-detail', compact(['sales_detail', 'sale', 'products', 'no']));
    }

    public function update(Request $request, $id)
    {
        $amont_product = $request->amount_product;
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        if ($product->stock < $amont_product) {
            return redirect()->route('transaksi.show', $id)->with('error', 'Barang tidak cukup');
        }
        $product->stock -= $amont_product;
        $product->save();

        $sub_total = $amont_product * $product->price;

        SaleDetail::create([
            'sale_id' => $id,
            'sub_total' => $sub_total,
            'amount_product' => $amont_product,
            'product_id' => $product_id,
        ]);

        $find_sale_detail = SaleDetail::where('sale_id', $id)->get();
        $total_price = $find_sale_detail->sum('sub_total');;

        $sale = Sale::find($id);
        $sale->total_price = $total_price;
        $sale->save();

        return redirect()->route('transaksi.show', $id);
    }

    public function destroy($id)
    {
        $sale_detail = SaleDetail::where('id', $id)->first();
        $amount_product = $sale_detail->amount_product;
        $sub_total = $sale_detail->sub_total;
        $sale_id = $sale_detail->sale_id;
        $product_id = $sale_detail->product_id;

        $product = Product::find($product_id);
        $product->stock += $amount_product;
        $product->save();

        $sale = Sale::find($sale_id);
        $sale->total_price -= $sub_total;
        $sale->save();

        $sale_detail->delete();

        return redirect()->route('transaksi.show', $sale_id);
    }

    public function cancel($id)
    {
        $sale = Sale::find($id);
        $sale_details = SaleDetail::where('sale_id', $id)->get();

        foreach ($sale_details as $sale_detail) {
            $product = Product::find($sale_detail->product_id);
            $product->stock += $sale_detail->amount_product;
            $product->save();
        }

        $sale->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibatalkan');
    }

    public function finish($id)
    {
        $sale_detail = SaleDetail::where('sale_id', $id)->get();
        if ($sale_detail->count() < 1) {
            return redirect()->route('transaksi.show', $id)->with('error', 'Belum ada barang yang ditambahkan di transaksi ini');
        }
        return redirect()->route('transaksi.index')->with('success', 'Berhasil melakukan transaksi');
    }
}
