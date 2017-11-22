<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dodavatel;


class DodavateliaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dodavatele = \App\Dodavatel::get();
        return view('dodavatele.dodavatele')->with('dodavatele', $dodavatele);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dodavatele.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dodavatel = new Dodavatel;

        $rules = [
            'nazev' => 'required|max:255',
            // TODO
        ];
        $this->validate($request, $rules);

        $dodavatel->nazev = $request->input('nazev');
        $dodavatel->typ = $request->input('jednorazovy') ? 1 : 0;
        if ($dodavatel->typ) {
            $dodavatel->datum_dodani = $request->input('datum_dodani');
        } else {
            $dodavatel->platnost_smlouvy_od = $request->input('platnost_smlouvy_od');
            $dodavatel->platnost_smlouvy_do = $request->input('platnost_smlouvy_do');
        }
        if ($dodavatel->save()) {
            $request->session()->flash('status-success', "Dodavatel <b>$dodavatel->nazev</b> byl úspěšně vytvořen.");
        } else {
            $request->session()->flash('status-fail', "Dodavatele <b>$dodavatel->nazev</b> se nezdařilo vytvořit.");
        }

        return redirect()->route('dodavatele.index');
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
        return view('dodavatele.edit')->with('dodavatel', \App\Dodavatel::find($id));
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
        $dodavatel = Dodavatel::find($id);

        $rules = [
            'nazev' => 'required|max:255',
            // TODO
        ];
        $this->validate($request, $rules);

        $dodavatel->nazev = $request->input('nazev');
        $dodavatel->typ = $request->input('jednorazovy') ? 1 : 0;
        if ($dodavatel->typ) {
            $dodavatel->datum_dodani = $request->input('datum_dodani');
            $dodavatel->platnost_smlouvy_od = NULL;
            $dodavatel->platnost_smlouvy_do = NULL;
        } else {
            $dodavatel->datum_dodani = NULL;
            $dodavatel->platnost_smlouvy_od = $request->input('platnost_smlouvy_od');
            $dodavatel->platnost_smlouvy_do = $request->input('platnost_smlouvy_do');
        }
        if ($dodavatel->save()) {
            $request->session()->flash('status-success', "Dodavatel <b>$dodavatel->nazev</b> byl úspěšně změněn.");
        } else {
            $request->session()->flash('status-fail', "Dodavatele <b>$dodavatel->nazev</b> se nezdařilo změnit.");
        }

        return redirect()->route('dodavatele.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}