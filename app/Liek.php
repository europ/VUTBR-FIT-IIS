<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liek extends Model {
    protected $table = "leky";
    protected $primaryKey = "id_leku";

    /**
     * Get the phone record associated with the user.
     */
    public function pobocky() {
        return $this->belongsToMany('App\Pobocka', 'leky_na_pobockach', 'id_leku', 'id_pobocky');
    }
}
