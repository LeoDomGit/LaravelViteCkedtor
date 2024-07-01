<?php

namespace Leo\Services\Controllers;

use Leo\Services\Models\Services;
use Illuminate\Http\Request;
use App\Traits\HasCrud;
use Inertia\Inertia;

class ServicesController extends Controller
{
    use HasCrud;
    protected $model;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->model = Services::class;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $services)
    {
        //
    }
}
