<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dodavatel extends Model {
	protected $table = "dodavatele";
	protected $primaryKey = "id_dodavatele";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nazev',  'typ', 'datum_dodani', 'platnost_smlouvy_od', 'platnost_smlouvy_do'
    ];

}
