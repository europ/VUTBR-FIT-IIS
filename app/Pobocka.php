<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pobocka extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pobocky';
    protected $primaryKey = 'id_pobocky';


    /**
     * Get the phone record associated with the user.
     */
    public function leky() {
        return $this->belongsToMany('App\Liek', 'leky_na_pobockach', 'id_leku', 'id_pobocky');
    }

    public function zamestnanci() {
    	return $this->hasMany('App\User', 'id_pobocky');
    }
}
