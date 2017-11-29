<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PredpisyController extends Controller
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
        $predpisy =  \DB::table('predpisy')->select('predpisy.id_predpisu','predpisy.rodne_cislo','pojistovny.nazev_pojistovny')->join('pojistovny','pojistovny.id_pojistovny','=','predpisy.id_pojistovny')->get();
        return view('predpisy.predpisy')->with('predpisy', $predpisy);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $predpis = \App\Predpis::find($id);
        // return $predpis;
        return view('predpisy.show')->with(['predpis' => $predpis, 'leky' => $predpis->leky, 'poistovna' => $predpis->poistovna]);
        return \App\Predpis::find($id);
        return \App\Predpis::find($id)->leky;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $predpis    = \App\Predpis::find($id);
        $pojistovna = \App\Poistovna::find($predpis->id_pojistovny);
        
        return view('predpisy.confirm-delete')->with(
                                                        [
                                                            'predpis' => $predpis,
                                                            'pojistovna' => $pojistovna
                                                        ]
                                                    );
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
        $request->session()->flash('status-fail', "TODO: PredpisyController.destroy()");
        return redirect()->route('predpisy.index');
    }
}
