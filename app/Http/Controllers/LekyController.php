<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LekyController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show','lekyNaPobocce','lekyNaPobocceUser']);
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leky = \App\Liek::get();
        return view('leky.leky')->with('leky', $leky);
    }

    public function lekyNaPobocce($id_pobocky) {
        // $userPobockaId = \Auth::user()->id_pobocky;
        $leky = \App\Pobocka::find($id_pobocky)->leky;
        return view('leky.leky-na-pobocce')->with('leky',$leky);
    }


    //getting name of pobocka and drugs for logged in user
    public function lekyNaPobocceUser() {
        $userPobockaId = \Auth::user()->id_pobocky;
        $leky = \App\Pobocka::find($userPobockaId)->leky;
        $pobocka = \App\Pobocka::find($userPobockaId);
        return view('leky.leky-na-pobocce-user')->with(compact('leky','pobocka'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leky.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nazev' => 'required|max:255',
            'cena' => 'required|numeric'
        ];

        $this->validate($request, $rules);
        
        $lek = new \App\Liek;

        $lek->nazev = $request->input('nazev');
        $lek->cena = $request->input('cena');

        if ($lek->save()) {
            $request->session()->flash('status-success', "Lék <b>$lek->nazev</b> byl úspěšně vytvořen.");
        } else {
            $request->session()->flash('status-fail', "Lék <b>$lek->nazev</b> se nezdařilo vytvořit.");
        }

        return redirect()->route('leky'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lek = \App\Liek::find($id);
        return $lek->pobocky;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('leky.edit')->with('lek', \App\Liek::find($id));
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
        $lek = \App\Liek::find($id);
        $rules = [
            'nazev' => 'required|max:255',
            'cena' => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $lek->nazev = $request->input('nazev');
        $lek->cena = $request->input('cena');

        if ($lek->save()) {
            $request->session()->flash('status-success', "Lék <b>$lek->nazev</b> byl úspěšně upraven.");
        } else {
            $request->session()->flash('status-fail', "Lék <b>$lek->nazev</b> se nezdařilo upravit.");
        }

        return redirect()->route('leky'); 
    }


    public function naskladnit_form($id_leku) {
        return view('leky.naskladnit')->with(['lek' => \App\Liek::find($id_leku), 'pobocky' => \App\Pobocka::get()]);
    }


    public function naskladnit(Request $request, $id_leku) {
        $lek = \App\Liek::find($id_leku);

        $rules = [
            'mnozstvi' => 'required|numeric',
            'pobocka' => 'required|numeric|not_in:none'
        ];

        $this->validate($request, $rules);
        
        $pobocky = $lek->pobocky->find($request->input('pobocka'));
        $mnozstvi  = $request->input('mnozstvi');
        $err = false;
        if (count($pobocky) > 0) {
            if (count($pobocky) > 1) {
                foreach ($pobocky as $pobocka) {
                    $mnozstvi += $pobocka->pivot->mnozstvi;
                }
            } else {
                $mnozstvi += $pobocky->pivot->mnozstvi;
            }
            if ($mnozstvi >= 0) {
                $lek->pobocky()->updateExistingPivot($request->input('pobocka'), ['id_leku' => $id_leku, 'mnozstvi' => $mnozstvi]);
            } else {
                $err = "Pobočka by obsahovala záporný počet jednotek léku.";
            }
        } else {
            if ($mnozstvi >= 0) {
                $lek->pobocky()->attach($request->input('pobocka'), ['id_leku' => $id_leku, 'mnozstvi' => $mnozstvi]);
            } else {
                $err = "Pobočka by obsahovala záporný počet jednotek léku.";
            }
        }

        if ($err) {
            $request->session()->flash('status-fail', "Lék <b>$lek->nazev</b> nebyl naskladněn na pobočku <b>" . \App\Pobocka::find($request->input('pobocka'))->nazev_pobocky . "</b>: ".$err);
        } else {
            $request->session()->flash('status-success', "Lék <b>$lek->nazev</b> byl naskladněn na pobočku <b>" . \App\Pobocka::find($request->input('pobocka'))->nazev_pobocky . "</b> v počtě " . $request->input('mnozstvi') . ".");
        }

        return redirect()->route('leky');
    }


    public function xxx($id) {
        return count(\App\Liek::find($id)->pobocky);
    }

    public function confirmDelete($id)
    {
        $lek = \App\Liek::find($id);
        return view('leky.confirm-delete')->with('lek', $lek);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $lek = \App\Liek::find($id);

        if (\App\Liek::destroy($id)) {
            $request->session()->flash('status-success', "Lék <b>$lek->nazev</b> byl vymazán.");
        } else {
            $request->session()->flash('status-fail', "Lék <b>$lek->nazev</b> se nezdařilo smazat.");
        }
        
        return redirect()->route('leky');
    }
}
