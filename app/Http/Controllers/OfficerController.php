<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficerController extends Controller
{
    public function index()
    {
        $officers = User::where('role','!=','admin')->get();
        $no = 0;
        return view('officer',compact(['officers','no']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'officer'
        ]);

        return redirect()->route('petugas.index')->with('success','Berhasil Menambahkan Petugas');
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'password' => '',
            'email' => 'required|email|',
        ]);

        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'officer'
        ]);

        return redirect()->route('petugas.index')->with('success','Berhasil Update Petugas');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->route('petugas.index')->with('success','Berhasil Hapus Petugas');
    }
}
