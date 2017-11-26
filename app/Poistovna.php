<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poistovna extends Model
{
    //
    protected $table = 'pojistovny';
    protected $primaryKey = 'id_pojistovny';
    protected $fillable = [
        'nazev_pojistovny'
    ];
}
