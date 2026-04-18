<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class NotificationService
{

    protected $NotificationMessage;

    public function __construct(NotificationMessage $NotificationMessage)
    {
        $this->NotificationMessage = $NotificationMessage;
    }

    public function curlFonte($kukumpul, $message, $data)
    {
        
        $token = config('services.fonnte.token'); 

        $response = Http::withHeaders([
            'Authorization' => $token, // ganti TOKEN dengan token Fonnte Anda
        ])->post('https://api.fonnte.com/send', [
            'target'      => $data['nohp'],
            'message'     => $message,
            'countryCode' => '62', // opsional
        ]);


    }

    public function MessageApproval($kukumpul){

        $message = $this->NotificationMessage->ApprovalKukumpul($kukumpul);
        $data['nohp'] = $kukumpul->nohp; 
        $response = $this->curlFonte($kukumpul, $message, $data);
        return $response;

    }

    public function MessageSend($request, $data){

        $message = $this->NotificationMessage->SendKukumpul($request, $data);
        $data['nohp'] = $request->nohp;
        $response = $this->curlFonte(null, $message, $data);
        return $response;

    }
}
