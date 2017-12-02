<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dodavatel extends Model {
	protected $table = "dodavatele";
	protected $primaryKey = "id_dodavatele";

    public static function boot()
    {
        parent::boot();

        Dodavatel::deleting(function($dodavatel)
        {
            $id_dodavatele = $dodavatel->id_dodavatele;

            foreach ($dodavatel->leky as $dodavanyLek) {
                $dodavanyLek->pivot->delete();
            }

            if (count(\App\Dodavatel::find($id_dodavatele)->pobocky) > 0) {
                return false;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nazev',  'typ', 'datum_dodani', 'platnost_smlouvy_od', 'platnost_smlouvy_do'
    ];

    /**
     * Get the phone record associated with the user.
     */
    public function leky() {
        return $this->belongsToMany('App\Liek', 'ceny_dodavatelu', 'id_dodavatele', 'id_leku')->withPivot('cena');
    }

}
