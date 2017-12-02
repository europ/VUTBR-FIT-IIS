<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;



class PredpisyController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show','store', 'create', 'edit', 'update', 'confirmDelete', 'destroy']);
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
        $pojistovny = \App\Poistovna::get();
        $leky = \App\Liek::get();
        return view('predpisy.create')->with(['pojistovny' => $pojistovny,'leky' => $leky]);
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
        $predpis = new \App\Predpis;
        $rules = [
            'rodne_cislo' => array(
                                'required',
                                'regex:/^[0-9]{10,11}$/'
                            ),
            'pojistovna' => 'required|not_in:none',
            'leky' => 'required'
        ];

        $this->validate($request, $rules);

        $predpis->rodne_cislo = $request->input('rodne_cislo');
        $predpis->id_pojistovny = $request->input('pojistovna');


        $leky = $request->input('leky');


        if ($predpis->save()) {
            foreach($_POST['leky'] as $lek){
                DB::table('predpisy_leky')->insert(['id_leku' => $lek, 'id_predpisu'=> $predpis->id_predpisu]); 
            } 
            $request->session()->flash('status-success', "Předpis <b>$predpis->id_predpisu</b> byl úspěšně vytvoren.");
        } else {
            $request->session()->flash('status-fail', "Předpis se nezdařilo vytvorit.");
        }

        return redirect()->route('predpisy.index'); 
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
        $predpis = \App\Predpis::find($id);
        $pojistovny = \App\Poistovna::get();
        //TODO zobrazovat vsetky lieky pri predpise? predpisy budu v ramci celeho systemu a nie pobocky
        $leky = \App\Liek::get();

        $poistovnatmp = \App\Predpis::find($id);
        
        $poistovna = $poistovnatmp->id_pojistovny;
        
        $lekypredpisu = DB::table('predpisy_leky')->where('id_predpisu', $id)->get();

        return view('predpisy.edit')->with(['predpis' => $predpis, 'pojistovny' => $pojistovny, 'leky' => $leky,'pojist' => $poistovna , 'lekypredpisu' => $lekypredpisu]);
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
        
        $predpis = \App\Predpis::find($id);
        $rules = [
            'rodne_cislo' => array(
                    'required',
                    'regex:/^[0-9]{10,11}$/'
                ),
            'pojistovna' => 'required|not_in:none',
            'leky' => 'required'
        ];

        $this->validate($request, $rules);

        $predpis->rodne_cislo = $request->input('rodne_cislo');
        $predpis->id_pojistovny = $request->input('pojistovna');

        $leky = $request->input('leky');

        //remove all entries from predpisy leky
        DB::table('predpisy_leky')->where('id_predpisu', $id)->delete(); 

        if ($predpis->save()) {
            //add new entries to predpisy leky
            foreach($_POST['leky'] as $lek){
                DB::table('predpisy_leky')->insert(['id_leku' => $lek, 'id_predpisu'=> $predpis->id_predpisu]); 
            } 
            $request->session()->flash('status-success', "Předpis <b>$id</b> byl úspěšně upraven.");
        } else {
            $request->session()->flash('status-fail', "Předpis <b>$id</b> se nezdařilo upravit.");
        }

        return redirect()->route('predpisy.index'); 
    }

    public function confirmDelete($id)
    {
        $predpis    = \App\Predpis::find($id);
        $pojistovna = \App\Poistovna::find($predpis->id_pojistovny);
        
        return view('predpisy.confirm-delete')->with(['predpis' => $predpis, 'pojistovna' => $pojistovna]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $predpis = \App\Predpis::find($id);

        //vymazanie zo spojovacej tabulky, TODO osetrit? 
        DB::table('predpisy_leky')->where('id_predpisu', $id)->delete();   

        if (\App\Predpis::destroy($id)) {
            $request->session()->flash('status-success', "Předpis č. <b>$predpis->id_predpisu</b> byl vymazán.");
        } else {
            $request->session()->flash('status-fail', "Předpis č. <b>$predpis->id_predpisu</b> se nezdařilo smazat.");
        }


        return redirect()->route('predpisy.index');

    }
}
