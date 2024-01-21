<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        $no = 0;

        return view('customer',compact(['customers','no']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
        ]);

        Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Berhasil menambahkan pelanggan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
        ]);

        $customer = Customer::find($id);

        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Berhasil ubah pelanggan');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Berhasil hapus pelanggan');
    }
}
