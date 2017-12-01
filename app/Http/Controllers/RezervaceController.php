<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RezervaceController extends Controller
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
        $rezervace = \App\Rezervace::get();
        return view('rezervace.rezervace')->with('rezervace', $rezervace);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        //TODO zobrazovat vsetky lieky pri predpise? predpisy budu v ramci celeho systemu a nie pobocky
        $leky = \App\Liek::get();  
        return view('rezervace.create')->with(['leky' => $leky]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rezervace = new \App\Rezervace;
        $rules = [
            'jmeno_zakaznika' => 'required',
            'leky' => 'required'
        ];

        $this->validate($request, $rules);

        $rezervace->jmeno_zakaznika = $request->input('jmeno_zakaznika');


        $leky = $request->input('leky');


        if ($rezervace->save()) {
            foreach($_POST['leky'] as $lek){
                DB::table('rezervace_leky')->insert(['id_leku' => $lek, 'id_rezervace'=> $rezervace->id_rezervace]); 
            } 
            $request->session()->flash('status-success', "Předpis <b>$rezervace->id_rezervace</b> byl úspěšně vytvoren.");
        } else {
            $request->session()->flash('status-fail', "Předpis se nezdařilo vytvorit.");
        }

        return redirect()->route('rezervace.index'); 
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
        $rezervace = \App\Rezervace::find($id);
        return view('rezervace.show')->with(['rezervace' => $rezervace, 'leky' => $rezervace->leky]);
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
        $rezervace = \App\Rezervace::find($id);

        $leky = \App\Liek::get();

        $lekyrezervace = DB::table('rezervace_leky')->where('id_rezervace', $id)->get();

        return view('rezervace.edit')->with(['rezervace' => $rezervace, 'leky' => $leky, 'lekyrezervace' => $lekyrezervace]);

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
        $rezervace = \App\Rezervace::find($id);
        $rules = [
            'jmeno_zakaznika' => 'required',
            'leky' => 'required'
        ];

        $this->validate($request, $rules);

        $rezervace->jmeno_zakaznika = $request->input('jmeno_zakaznika');

        $leky = $request->input('leky');

        //remove all entries from rezervace leky
        DB::table('rezervace_leky')->where('id_rezervace', $id)->delete(); 

        if ($rezervace->save()) {
            //add new entries to predpisy leky
            foreach($_POST['leky'] as $lek){
                DB::table('rezervace_leky')->insert(['id_leku' => $lek, 'id_rezervace'=> $rezervace->id_rezervace]); 
            } 
            $request->session()->flash('status-success', "Rezervace <b>$id</b> byla úspěšně upravena.");
        } else {
            $request->session()->flash('status-fail', "Rezervace <b>$id</b> se nezdařilo upravit.");
        }

        return redirect()->route('rezervace.index'); 
    }

    public function confirmDelete($id)
    {
        $rezervace = \App\Rezervace::find($id);
        return view('rezervace.confirm-delete')->with('rezervace', $rezervace);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rezervace = \App\Rezervace::find($id);

        //vymazanie zo spojovacej tabulky, TODO osetrit? 
        DB::table('rezervace_leky')->where('id_rezervace', $id)->delete();   

        if (\App\Rezervace::destroy($id)) {
            $request->session()->flash('status-success', "Rezervace č. <b>$rezervace->id_rezervace</b> byla vymazána.");
        } else {
            $request->session()->flash('status-fail', "Rezervace č. <b>$rezervace->id_rezervace</b> se nezdařilo smazat.");
        }


        return redirect()->route('rezervace.index');
    }
}
