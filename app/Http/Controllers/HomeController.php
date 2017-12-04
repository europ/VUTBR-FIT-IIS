<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pobocky = \App\Pobocka::get();
        $prodanoCount = 0;
        foreach ($pobocky as $key => $pobocka) {
            foreach ($pobocka->prodaneLeky as $key => $prodej) {
                $prodanoCount += $prodej->pivot->mnozstvi;
                // return $prodejmnozstvi
            }
        }


        return view('dashboard')->with([
            'users_count' => count(\App\User::get()),
            'pobocky_count' => count(\App\Pobocka::get()),
            'prodane_leky_count' => $prodanoCount,
            'dodavatele_count' => count(\App\Dodavatel::get())
        ]);
        // return view('home');
    }
}
