<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegrationController
{
public function amoRedirect(Request $request)
{
    dd($request->all());
}
}
