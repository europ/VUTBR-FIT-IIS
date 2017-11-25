<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Predpis extends Model {
    protected $table = "predpisy";
    protected $primaryKey = "id_predpisu";

    /**
     * Get the phone record associated with the user.
     */
    public function poistovna() {
    	// TODO FIXIT
        return $this->belongsTo('App\Poistovna', 'id_pojistovny');
    }

}
