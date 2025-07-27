<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kedatangan;
use App\Models\ProdukKlien;

class KedatanganController extends Controller
{
    public function index($produk_klien_id)
    {
        $produk_klien_id = decrypt($produk_klien_id);

        // Ambil data produk klien
        $klien = ProdukKlien::findOrFail($produk_klien_id);

        $kedatangan = Kedatangan::with('produkKlien')
            ->where('produk_klien_id', $produk_klien_id)
            ->orderBy('created_at')
            ->get();

        $result = collect();

        if ($kedatangan->count() > 0) {
            $qty_kiri = $klien->qty;
            foreach ($kedatangan as $row) {
                $row->qty_kiri = $qty_kiri;
                $row->sisa = $qty_kiri - $row->qty;
                $qty_kiri = $row->sisa;
                $result->push($row);
            }
        }

        return view('admin.terkirim.index', ['kedatangan' => $result, 'klien' => $klien]);
    }

    public function destroy($id)
    {
        $kedatangan = \App\Models\Kedatangan::findOrFail($id);
        $produk_klien_id = $kedatangan->produk_klien_id;
        $kedatangan->delete();
        $produk = \App\Models\ProdukKlien::find($produk_klien_id);
        if ($produk) {
            $produk->qty_terkirim = $produk->kedatangan()->whereNull('deleted_at')->sum('qty');
            $produk->save();
        }

        return redirect()->route('terkirim.index', encrypt($produk_klien_id))->with('success', 'Data berhasil dihapus.');
    }
}
