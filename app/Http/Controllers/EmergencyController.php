<?php

namespace App\Http\Controllers;

use App\Models\Emergency;
use App\Http\Requests\StoreEmergencyRequest;
use App\Http\Requests\UpdateEmergencyRequest;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('emergency.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emergency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmergencyRequest $request)
    {
        return view('emergency.store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Emergency $emergency)
    {
        return view('emergency.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emergency $emergency)
    {
        return view('emergency.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmergencyRequest $request, Emergency $emergency)
    {
        return view('emergency.update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emergency $emergency)
    {
        return view('emergency.destroy');
    }
}
