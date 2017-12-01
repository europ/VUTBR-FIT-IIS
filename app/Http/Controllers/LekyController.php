<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LekyController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show','lekyNaPobocce','lekyNaPobocceUser', 'vydat_form', 'vydat']);
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
        
        $lek = new \App\Liek;


        $rules = [
            'nazev' => [
                'required',
                'max:255',
                Rule::unique('leky', 'nazev')->ignore($lek->id_leku, 'id_leku')
            ],
            'cena' => 'required|numeric'
        ];

        $this->validate($request, $rules);


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
            'nazev' => [
                'required',
                'max:255',
                Rule::unique('leky', 'nazev')->ignore($lek->id_leku, 'id_leku')
            ],
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

    public function vydat_form(Request $request, $id_leku) {

        $userPobockaId = \Auth::user()->id_pobocky;

        $lek = \App\Pobocka::find($userPobockaId)->leky()->where('leky_na_pobockach.id_leku', $id_leku)->first();
        $mnozstvi = $lek->pivot->mnozstvi;

        return view('leky.vydat')->with(['lek' => $lek, 'max' => $mnozstvi]);


        // $lek->pobocky()->updateExistingPivot($request->input('pobocka'), ['id_leku' => $id_leku, 'mnozstvi' => $mnozstvi]);



        if ($userPobockaId != NULL) {
            // $lek = \App\Liek::find($id_leku)->pobocky()->where('id_pobocky', $userPobockaId)->first();
            $pobocka = \App\Pobocka::find($userPobockaId)->leky()->where('leky_na_pobockach.id_leku', $id_leku)->first();
            return $pobocka->pivot->mnozstvi;
            return redirect()->route('leky')->with(['lek' => $lek, 'mnozstvi' => $lek->mnozstvi]);
            $lek = \App\Pobocka::find($userPobockaId)->leky()->where('leky_na_pobockach.id_leku', $id_leku)->first();
        } else {
            $request->session()->flash('status-fail', "Léky může vydávat pouze lekárník.");
            return redirect()->route('leky');
        }

        $leky = \App\Pobocka::find($userPobockaId)->leky;
        $pobocka = \App\Pobocka::find($userPobockaId);

        // if ($) {
        //     # code...
        // }
        // return \App\Liek::find($id_leku)->pobocky;
    }

    public function vydat(Request $request, $id_leku) {
        $userPobockaId = \Auth::user()->id_pobocky;
        $lek = \App\Pobocka::find($userPobockaId)->leky()->where('leky_na_pobockach.id_leku', $id_leku)->first();

        $nove_mnozstvi = $lek->pivot->mnozstvi - $request->input('mnozstvi');

        \App\Liek::find($id_leku)->pobocky()->updateExistingPivot($userPobockaId, ['id_leku' => $lek->id_leku, 'mnozstvi' => $nove_mnozstvi]);

        // $lek->pobocky()->attach($request->input('pobocka'), ['id_leku' => $id_leku, 'mnozstvi' => $mnozstvi]);
        \App\Liek::find($id_leku)->prodane()->attach($id_leku, ['mnozstvi' => $request->input('mnozstvi'), 'datum' => date("Y-m-d"), 'id_pobocky' => $userPobockaId]);

        $request->session()->flash('status-success', "Lék byl označen jako vydán v počtě ".$request->input('mnozstvi'));

        return redirect()->route('leky-na-pobocce');

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



        if (\App\Liek::destroy($id)) {
            $request->session()->flash('status-success', "Lék <b>$lek->nazev</b> byl vymazán.");
        } else {
            $request->session()->flash('status-fail', "Lék <b>$lek->nazev</b> se nezdařilo smazat.");
        }
        
        return redirect()->route('leky');
    }
}
