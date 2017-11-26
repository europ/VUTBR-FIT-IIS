<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoistovnyController extends Controller
{


    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
        $this->middleware('auth');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poistovny = \App\Poistovna::get();
        return view('poistovny.poistovny')->with('poistovny', $poistovny);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('poistovny.create');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poistovna = \App\Poistovna::find($id);
        return view('poistovny.edit')->with('poistovna', $poistovna);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function confirmDelete($id)
    {
        $poistovna = \App\Poistovna::find($id);
        return view('poistovny.confirm-delete')->with('poistovna', $poistovna);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        // TODO
        // remove $poistovna from tables: pojistovny, predpisy_leky

        $request->session()->flash('status-fail', "TODO: PoistovnyController::destroy()");
        return redirect()->route('poistovny.index');
    }


}
