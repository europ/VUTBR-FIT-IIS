<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use App\User;
use App\Pobocka;



class UserController extends Controller
{
    


    public function __construct()
    {
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.list-users')->with('users', $users);
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
        // TODO - ak taky user neexistuje, sprav nieco
        $user = User::find($id);
        return $user;
        // return view('')
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit-user')->with('user', User::find($id))->with('pobocky', Pobocka::get());
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
        $user = User::find($id);
        $rules = [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'name' => 'required|max:255',
        ];

        if (!empty($request->input('password'))) {
            $rules['password'] = 'min:6|confirmed';
        }

        $this->validate($request, $rules);

       //  $this->validate($request, [
       //     'email' => 'required|email|max:255|unique:users,email,'.User::find($id)->email,
       //     'password' => 'min:6|confirmed'
       // ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email    = $request->input('email');
        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        if ($request->input('pobocka') != "none") {
            $user->id_pobocky = $request->input('pobocka');
        } else {
            $user->id_pobocky = NULL;
        }
        $user->admin = $request->input('is_admin') ? 1 : 0;
        $user->save();

        return redirect('/');

    }

    public function confirmDelete($id)
    {
        $user = User::find($id);
        return view('users.confirm-delete')->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $email = User::find($id);
        if (User::destroy($id)) {
            $request->session()->flash('status-success', "Užívatel <b>$email->email</b> byl úspěšně vymazán.");
        }
        else {
            $request->session()->flash('status-fail', "Užívatele <b>$email->email</b> se nezdařilo smazat.");
        }

        return view('users.list-users')->with('users', User::get());
    }
}
