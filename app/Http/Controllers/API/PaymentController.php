<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController
{
    public function saveSuccessPaymentInfo(Request $request)
    {
        $data = $request->all();
        Log::info('УСПЕШНО' . json_encode($data));

        return response()->json(['success' => true], 200);
    }
}
