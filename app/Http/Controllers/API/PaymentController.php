<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController
{
    public function saveSuccessPaymentInfo(Request $request)
    {
        $data = $request->all();
        Log::channel('payments')->info('УСПЕШНО' . json_encode($data));

        return response()->json(['success' => true], 200);
    }

    public function saveFailedPaymentInfo(Request $request)
    {
        $data = $request->all();
        Log::channel('payments')->info('ОШИБКА ОПЛАТЫ' . json_encode($data));

        return response()->json(['success' => true], 200);
    }
}
