<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Services\CadenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalaryController extends Controller
{


    public function index()
    {
        return view('salaries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



}
