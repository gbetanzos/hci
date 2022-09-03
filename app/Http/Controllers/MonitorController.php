<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(),[
			'host'=>'required',
			'port'=>'required',
			'protocol'=>'required',
            'frequency'=>'required'
			]);

    	$m=new Monitor();
        $m->host=request()->host;
        $m->port=request()->port;
        $m->protocol=request()->protocol;
        $m->frequency=request()->frequency;
        $m->user_id=Auth::id();
        $m->save();
        
    	$msg="New Monitor has been created";
        return back()->with('success', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitor  $Monitor
     * @return \Illuminate\Http\Response
     */
    public function show(Monitor $monitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitor  $Monitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Monitor $monitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monitor  $Monitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monitor $Monitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitor  $Monitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monitor $Monitor)
    {
        //
    }
}