<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class PageController
{
    public function paymentPage()
    {
        return view('payment');
    }

    public function paymentResult()
    {
        $paymentFilePath = storage_path('logs/payments.log');

        if (File::exists($paymentFilePath)) {
            $paymentContents = File::get($paymentFilePath);
        } else {
            $paymentContents = 'файл не найден.';
        }
        return view('payment-result', compact('paymentContents'));
    }
}
