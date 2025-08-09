<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBank;

class MasterbankController extends Controller
{
    public function index(){

        $obj['banks'] = MasterBank::orderBy('created_at', 'desc')->get();

        return view('admin.bank.index', compact('obj'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
        ]);

        // Simpan ke database
        MasterBank::create([
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'cby'            => auth()->id(), // ID user yang membuat
        ]);

        // Redirect dengan notifikasi
        return redirect()->back()->with('success', 'Data bank berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $bank = MasterBank::findOrFail($id);
        $bank->delete();
        return redirect()->back()->with('success', 'Data bank berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
        ]);

        $bank = MasterBank::findOrFail($id);
        $bank->update([
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'mby'            => auth()->id()
        ]);

        return redirect()->route('bank.index')->with('success', 'Bank berhasil diperbarui');
    }

}
