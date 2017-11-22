<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Pobocka;
use App\User;
class PobockyController extends Controller
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
    public function index() {
        $pobocky = Pobocka::get();
        return view('pobocky.pobocky')->with('pobocky', $pobocky);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pobocky.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pobocka = new Pobocka;

        $rules = [
            'nazev_pobocky' => 'required|max:255',
            'adresa_ulice' => 'required|max:255',
            'adresa_mesto' => 'required|max:255',
            'adresa_cislo' => 'required|max:255',
            'adresa_psc' => 'required|max:255'
        ];

        $this->validate($request, $rules);

        // TODO - mohli by sme validovat, ake PSC zadal uzivatel,
        // zobrat aj "900 42", teraz to berie len integer

        $pobocka->nazev_pobocky = $request->input('nazev_pobocky');
        $pobocka->adresa_ulice = $request->input('adresa_ulice');
        $pobocka->adresa_mesto = $request->input('adresa_mesto');
        $pobocka->adresa_cislo = $request->input('adresa_cislo');
        $pobocka->adresa_psc = $request->input('adresa_psc');

        if ($pobocka->save()) {
            $request->session()->flash('status-success', "Pobočka <b>$pobocka->nazev_pobocky</b> byla úspěšně vytvořena.");
        } else {
            $request->session()->flash('status-fail', "Pobočku <b>$pobocka->nazev_pobocky</b> se nezdařilo vytvořit.");
        }

        return redirect()->route('pobocky.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return count(\App\Pobocka::find($id)->leky);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $pobocka = \App\Pobocka::find($id);
        return view('pobocky.edit')->with('pobocka', $pobocka);
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
        $pobocka = Pobocka::find($id);
        $rules = [
            'nazev_pobocky' => 'required|max:255',
            'adresa_ulice' => 'required|max:255',
            'adresa_mesto' => 'required|max:255',
            'adresa_cislo' => 'required|max:255',
            'adresa_psc' => 'required|max:255'
        ];

        $this->validate($request, $rules);

        // TODO - mohli by sme validovat, ake PSC zadal uzivatel,
        // zobrat aj "900 42", teraz to berie len integer

        $pobocka->nazev_pobocky = $request->input('nazev_pobocky');
        $pobocka->adresa_ulice = $request->input('adresa_ulice');
        $pobocka->adresa_mesto = $request->input('adresa_mesto');
        $pobocka->adresa_cislo = $request->input('adresa_cislo');
        $pobocka->adresa_psc = $request->input('adresa_psc');

        if ($pobocka->save()) {
            $request->session()->flash('status-success', "Pobočka <b>$pobocka->nazev_pobocky</b> byla úspěšně upravena.");
        } else {
            $request->session()->flash('status-fail', "Pobočku <b>$pobocka->nazev_pobocky</b> se nezdařilo upravit.");
        }

        return redirect()->route('pobocky.index');
    }

    public function confirmDelete($id)
    {
        $pobocka = Pobocka::find($id);
        return view('pobocky.confirm-delete')->with('pobocka', $pobocka);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pobocka = Pobocka::find($id);
        if (count($pobocka->leky) != 0) {
            $request->session()->flash('status-fail', "Pobočka <b>$pobocka->nazev_pobocky</b> nebyla smazána, protože na pobočce jsou evidovány léky. Pokud chcete pobočku smazat, smažte všechny léky, které jsou navázány na tuto pobočku.");
            return redirect()->route('pobocky.index');
        }

        if (count($pobocka->zamestnanci) != 0) {
            $request->session()->flash('status-fail', "Pobočka <b>$pobocka->nazev_pobocky</b> nebyla smazána, protože pobočka obsahuje pracovníky. Pokud chcete pobočku smazat, smažte všechny pracovníky, kteří jsou na tuto pobočku navázáni.");
            return redirect()->route('pobocky.index');
        }


        if (Pobocka::destroy($id)) {
            $request->session()->flash('status-success', "Pobočka <b>$pobocka->nazev_pobocky</b> byla úspěšně smazána.");
        } else {
            $request->session()->flash('status-fail', "Pobočku <b>$pobocka->nazev_pobocky</b> se nezdařilo smazat.");
        }
        
        return redirect()->route('pobocky.index');
        // return view('pobocky.pobocky')->with('pobocky', Pobocka::get());
    }
}
