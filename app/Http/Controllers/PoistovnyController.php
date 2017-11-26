<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poistovna;
use DB;
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
        $poistovna = new Poistovna;

        $rules = [
            'nazev_pojistovny' => 'required|max:255',
        ];

        $this->validate($request, $rules);



        $poistovna->nazev_pojistovny = $request->input('nazev_pojistovny');


        if ($poistovna->save()) {
            $request->session()->flash('status-success', "Pojišťovna <b>$poistovna->nazev_pojistovny</b> byla úspěšně vytvořena.");
        } else {
            $request->session()->flash('status-fail', "Pojišťovnu <b>$poistovna->nazev_pojistovny</b> se nezdařilo vytvořit.");
        }

        return redirect()->route('poistovny.index');
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
        $poistovna = \App\Poistovna::find($id);
        $rules = [
            'nazev_pojistovny' => 'required|max:255',
        ];

        $this->validate($request, $rules);


        $poistovna->nazev_pojistovny = $request->input('nazev_pojistovny');
        

        if ($poistovna->save()) {
            $request->session()->flash('status-success', "Pojišťovna <b>$poistovna->nazev_pojistovny</b> byla úspěšně upravena.");
        } else {
            $request->session()->flash('status-fail', "Pojišťovnu <b>$poistovna->nazev_pojistovny</b> se nezdařilo upravit.");
        }

        return redirect()->route('poistovny.index');
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

        $poistovna = \App\Poistovna::find($id);


        //TODO
        $poistovny_rezer =  DB::table('pojistovny')->join('predpisy','pojistovny.id_pojistovny','=','predpisy.id_pojistovny')->select('*')->where('id_pojistovny','=',$id)->get()->count();


        // TODO
        // remove $poistovna from tables: predpisy
        // do this for other destroys too!!!


        if ($poistovny_rezer != 0) {
            $request->session()->flash('status-fail', "Pojišťovna <b>$poistovna->nazev_pojistovny</b> nebyla smazána, protože v systéme jsou evidovány předpisy, které odkazují na danú pojišťovnu. Pokud chcete pojišťovnu smazat, smažte všechny předpisy, které jsou navázány na tuto pojišťovnu.");
            return redirect()->route('poistovny.index');
        }



        if (\App\Poistovna::destroy($id)) {
            $request->session()->flash('status-success', "Pojišťovna <b>$poistovna->nazev_pojistovny</b> byla úspěšně smazána.");
        } else {
            $request->session()->flash('status-fail', "Pojišťovnu <b>$poistovna->nazev_pojistovny</b> se nezdařilo smazat.");
        }
        
        return redirect()->route('poistovny.index');
    }


}
