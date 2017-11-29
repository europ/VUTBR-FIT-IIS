<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Predpis extends Model {
    protected $table = "predpisy";
    protected $primaryKey = "id_predpisu";

    /**
     * Get the phone record associated with the user.
     */

    //do we need this? TODO
    public function poistovna() {
        return $this->belongsTo('App\Poistovna', 'id_pojistovny');
    }

    public function leky() {
    	return $this->belongsToMany('App\Liek', 'predpisy_leky', 'id_predpisu', 'id_leku');
    }

}
