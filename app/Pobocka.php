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
    protected $fillable = [
        'adresa_ulice', 'adresa_mesto', 'adresa_cislo', 'adresa_psc'
    ];

    /**
     * Get the phone record associated with the user.
     */
    public function leky() {
        return $this->belongsToMany('App\Liek', 'leky_na_pobockach', 'id_pobocky', 'id_leku')->withPivot('mnozstvi');
    }

    public function prodaneLeky() {
        return $this->belongsToMany('App\Liek', 'prodane_leky', 'id_pobocky', 'id_leku')->withPivot(['datum', 'mnozstvi']);
    }

    public function zamestnanci() {
    	return $this->hasMany('App\User', 'id_pobocky');
    }
}
