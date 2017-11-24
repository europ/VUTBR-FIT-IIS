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
