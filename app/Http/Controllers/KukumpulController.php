<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBank;
use App\Models\Kukumpul;
use App\Services\notificationService;

class KukumpulController extends Controller
{
    
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request){

        $query  = Kukumpul::query();
        if ($request->filled('periode')) {
            [$bulan, $tahun] = explode('/', $request->periode);
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }
        $obj['kukumpul'] = $query->orderBy('status', 'asc')->get();
        $obj['periode']  = $request->periode;

        $obj['terkumpul'] = $obj['kukumpul']->where('status', 'sukses')->sum('rupiah');
        $obj['invoice']   = $obj['kukumpul']->where('status', 'sukses')->count('rupiah');

        return view('admin.kukumpul.index', compact('obj'));
    }

    public function show($id)
    {
        $item = Kukumpul::findOrFail($id);

        if (request()->ajax()) {
            return response()->json($item);
        }

        // kalau akses normal (non-AJAX) bisa return view
        return view('admin.kukumpul.show', compact('item'));
    }

    public function markSukses($id){

        $kukumpul = Kukumpul::findOrFail($id);
        $response = $this->notificationService->MessageApproval($kukumpul); 
        if ($kukumpul->status === 'proses') {
            $kukumpul->status = 'sukses';
            $kukumpul->save();
        }

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi Sukses.');
    }

    public function markReload($id){

        $kukumpul = Kukumpul::findOrFail($id);

        if ($kukumpul->status === 'sukses') {
            $kukumpul->status = 'proses';
            $kukumpul->save();
        }

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi Sukses.');
    }

    


}
