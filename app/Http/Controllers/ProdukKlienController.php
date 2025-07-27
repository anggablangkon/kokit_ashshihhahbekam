<?php

namespace App\Http\Controllers;

use App\Models\ProdukKlien;
use App\Models\Kedatangan;
use Illuminate\Http\Request;
use Auth;
use DB;

class ProdukKlienController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_klien'    => 'required|string|max:100',
            'jenis_produk'  => 'required|in:CK,BT,BE',
            'qty'           => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
        ]);

        // Konversi ke huruf besar (string saja)
        foreach ($validated as $key => $value) {
            if (is_string($value)) {
                $validated[$key] = strtoupper($value);
            }
        }

        $date = date('ymd'); // 2 digit tahun
        $countToday = ProdukKlien::whereDate('created_at', date('Y-m-d'))->count();
        $noPo = 'PO' . $validated['jenis_produk'] . $date . '-' . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        $validated['no_po'] = $noPo;
        $validated['cby']   = Auth()->id();
        $validated['qty_terkirim']   = 0;
        ProdukKlien::create($validated);

        return redirect('/dashboard')->with('success', "Data klien berhasil disimpan dengan No PO: $noPo");
    }


    // public function ajaxLoad(Request $request)
    // {
    //     $keyword = $request->input('keyword');
    //     $produkKlien = ProdukKlien::when($keyword, function ($query, $keyword) {
    //         $query->where('nama_klien', 'like', '%' . $keyword . '%')
    //             ->orWhere('no_po', 'like', '%' . $keyword . '%');
    //     })->get();
    //     return view('admin.dashboard.data-table', compact('produkKlien'));
    // }

    public function ajaxLoad(Request $request)
    {
        $keyword = $request->input('keyword');
        $perPage = 5;

        $produkKlien = ProdukKlien::when($keyword, function ($query, $keyword) {
            $query->where('nama_klien', 'like', '%' . $keyword . '%')
                ->orWhere('no_po', 'like', '%' . $keyword . '%');
        })->paginate($perPage); // <-- gunakan paginate()

        // Render HTML <tr> saja
        $html = view('admin.dashboard.data-table', compact('produkKlien'))->render();

        // Kirim juga data pagination ke JavaScript
        return response()->json([
            'html' => $html,
            'pagination' => [
                'total' => $produkKlien->total(),
                'per_page' => $produkKlien->perPage(),
                'current_page' => $produkKlien->currentPage(),
                'last_page' => $produkKlien->lastPage(),
                'from' => $produkKlien->firstItem(),
                'to' => $produkKlien->lastItem(),
            ]
        ]);
    }


    public function ajaxLoadKlien($token)
    {

        try {
            $produkKlien = ProdukKlien::where('id', decrypt($token))->firstOrFail();
            return response()->json([
                'success' => true,
                'data'    => $produkKlien
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan atau token tidak valid.',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_klien' => 'required|string|max:100',
            'jenis_produk' => 'required|in:CK,BT,BE',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);
        $produk = \App\Models\ProdukKlien::findOrFail($id);
        $produk->update($validated);
        return response()->json(['success' => true, 'message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $produk = \App\Models\ProdukKlien::findOrFail($id);
        $produk->delete();
        return redirect()->back()->with('success', 'Klien berhasil dihapus.');
    }

    public function savekedatangan(Request $request)
    {

        try {
            $produkId = decrypt($request->produk_id);
            $produk = ProdukKlien::findOrFail($produkId);
            $sisa = $produk->qty - $produk->qty_terkirim;

            $validated = $request->validate([
                'qty'        => 'required|integer|min:1',
                'keterangan' => 'nullable|string',
            ]);

            // Simpan data kedatangan
            $kedatangan = new Kedatangan();
            $kedatangan->produk_klien_id = $produkId;
            $kedatangan->qty = $validated['qty'];
            $kedatangan->keterangan = $validated['keterangan'] ?? null;
            $kedatangan->save();

            // Update qty_kedatangan di produk_klien
            $produk->qty_terkirim = ($produk->qty_terkirim ?? 0) + $validated['qty'];
            $produk->save();

            return response()->json([
                'success' => true,
                'message' => 'Data terkirim berhasil disimpan dan qty_terkirim diupdate.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function chartData()
    {

        $data = ProdukKlien::select(
            'jenis_produk as kode',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(qty_terkirim) as qty'),
            DB::raw('SUM(qty - qty_terkirim) as kedatangan')
        )
            ->groupBy('jenis_produk')
            ->get();

        return response()->json($data);
    }


    public function chartSummary()
    {

        $data = ProdukKlien::select(
            DB::raw('UPPER(jenis_produk) as kode'),
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(qty_terkirim) as qty'),
            DB::raw('SUM(qty - qty_terkirim) as kedatangan')
        )
            ->groupBy(DB::raw('UPPER(jenis_produk)'))
            ->get();

        return view('admin.dashboard.summary-data', compact('data'));
    }
}
