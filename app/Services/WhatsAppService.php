<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function send($phone, $message)
    {
        // مؤقتًا نسجل الرسالة في اللوج

        Log::info('WhatsApp Message', [
            'phone' => $phone,
            'message' => $message
        ]);

        return true;
    }
    public function sendQueueNotification($appointment, $remaining)
    {
        switch ($remaining) {

            case 0:
                $message = "يرجى التوجه إلى العيادة، دورك هو التالي.";
                break;

            case 1:
                $message = "متبقي أمامك موعد واحد.";
                break;

            case 2:
                $message = "متبقي أمامك موعدان.";
                break;

            default:
                $message = "متبقي أمامك {$remaining} مواعيد.";
        }

        return $this->send(
            $appointment->patient->phone,
            $message
        );
    }
}
