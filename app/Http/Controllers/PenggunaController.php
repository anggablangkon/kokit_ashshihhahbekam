<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kukumpul;
use App\Models\MasterBank;
use App\Models\Testimonial;
use App\Services\notificationService;


class PenggunaController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $testimonis = Testimonial::all();
        return view('home.landingpage', compact('testimonis'));
    }

    public function profil()
    {
        return view('home.profil');
    }

    public function teknis()
    {
        return view('home.teknis');
    }

    public function store(Request $request)
    {

        try {
            // Sanitasi nomor HP
            $nohp    = preg_replace('/\D/', '', $request->nohp);
            $last3   = substr($nohp, -3);
            $tanggal = date('ymd');
            $random  = rand(100, 999);

            // Buat invoice unik
            $invoice = 'INV' . $tanggal . $last3 . $random;
            while (Kukumpul::where('invoice', $invoice)->exists()) {
                $random  = rand(100, 999);
                $invoice = 'INV' . $tanggal . $last3 . $random;
            }

            // Hitung jumlah data bulan ini
            $jumlah_bulan_ini = Kukumpul::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

            // Kode unik = urutan data + 1
            $kode_unik = $jumlah_bulan_ini + 1;

            // Ambil nominal asli dan bersihkan
            $nominal = (int) preg_replace('/\D/', '', $request->nominal);

            // Gabungkan nominal + kode unik
            $rupiah_final = $nominal + $kode_unik;

            // Simpan data
            $data = Kukumpul::create([
                'nama'        => $request->nama,
                'nohp'        => $nohp,
                'cby'         => 0,
                'rupiah'      => $rupiah_final,
                'invoice'     => $invoice,
                'keterangan'  => $request->catatan,
                'provinsi_id' => $request->domisili,
                'tanggal'     => now(),
            ]);

            ### notifikasi wa
            $data['invoice'] = $invoice;
            $data['rupiah']  = $rupiah_final;
            $response = $this->notificationService->MessageSend($request, $data);

            return response()->json([
                'status'   => true,
                'message'  => 'Kontribusi berhasil disimpan.',
                'redirect' => route('pembayaran.index', ['invoice' => $invoice]),
            ]);
        } catch (\Exception $e) {
            // Tangkap error dan kirim respon gagal
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function pembayaran($invoice)
    {
        $banks = MasterBank::all();
        $data = Kukumpul::where('invoice', $invoice)->firstOrFail();
        return view('home.pembayaran', compact('data', 'banks'));
    }
}
