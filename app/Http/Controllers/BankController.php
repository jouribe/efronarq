<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Bank $bank
     * @return Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Bank $bank
     * @return Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return Response
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Bank $bank
     * @return Response
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
