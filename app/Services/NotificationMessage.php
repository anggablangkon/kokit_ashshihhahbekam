<?php

namespace App\Services;
use App\Models\MasterBank;

class NotificationMessage
{
    public function ApprovalKukumpul($kukumpul)
    {

        // pesan informasi uang sudah di terima
        $pesan  = "Alhamdulillah, donasi dengan nomor invoice *".$kukumpul->invoice."* yang Bapak/Ibu *".$kukumpul->nama."* titipkan sebesar *".rupiah($kukumpul->rupiah)."* sudah kami terima.";
        $pesan .= "Terima kasih atas kepercayaannya, semoga menjadi keberkahan untuk kita semua 🙏\n\n";
        $pesan .= "Untuk konfirmasi pembayaran atau pertanyaan lebih lanjut bisa menghubungi nomor ini: *wa.me/+6281586777429*\n\n";
        $pesan .= "Salam,\nKukumpul Foundation "; 
        return $pesan;

    }

    public function SendKukumpul($request, $data)
    {

        $pesan  = "Hai Ka *".$request->nama."*\n";
        $pesan .= "Terima kasih telah menjadi kontributor Kukumpul 🙏\n\n";
        $pesan .= "Nomor Invoice: *".($data['invoice'] ?? null)."*\n";
        $pesan .= "Nominal Transfer: *".rupiah($data['rupiah'])."*\n\n";
        $pesan .= "Silakan transfer ke salah satu rekening berikut:\n";

        $banks = MasterBank::all();
        foreach ($banks as $bank) {
            $pesan .= "- Bank {$bank->bank_name}\n";
            $pesan .= " Rekening: {$bank->account_number}\n";
            $pesan .= " A/N: {$bank->account_holder}\n\n";
        }

        $pesan .= "⚠️ Harap transfer sesuai nominal hingga 3 digit terakhir dan simpan bukti transfer.\n\n";
        $pesan .= "Untuk konfirmasi pembayaran atau pertanyaan lebih lanjut bisa menghubungi nomor ini: *wa.me/+6281586777429*\n\n";
        $pesan .= "Salam,\n*Kukumpul Foundation*";

        return $pesan;

    }
}
