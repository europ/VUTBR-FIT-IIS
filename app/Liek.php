<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liek extends Model {
	protected $table = "leky";
	protected $primaryKey = "id_leku";

	public static function boot()
	{
		parent::boot();

		Liek::deleting(function($liek)
		{
			$id_leku = $liek->id_leku;

			foreach ($liek->pobocky as $pobocka) {
				$pobocka->pivot->delete();
			}

			if (count(\App\Liek::find($id_leku)->pobocky) > 0) {
				return false;
			}
		});
	}

    public function pobocky() {
    	return $this->belongsToMany('App\Pobocka', 'leky_na_pobockach', 'id_leku', 'id_pobocky')->withPivot('mnozstvi');
    }

    public function dodavatele() {
    	return $this->belongsToMany('App\Dodavatel', 'ceny_dodavatelu', 'id_leku', 'id_dodavatele')->withPivot('cena');
    }

}
