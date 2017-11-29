<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rezervace extends Model {
    protected $table = "rezervace";
    protected $primaryKey = "id_rezervace";


    public function leky() {
		return $this->belongsToMany('App\Liek', 'rezervace_leky', 'id_rezervace', 'id_leku');
	}

}


