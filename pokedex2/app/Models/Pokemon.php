<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Pokemon extends Model
{
    protected $table="Pokedex";
    protected $primaryKey= 'id_pok';

    public function types(){
    	return $this->hasOne('App\Models\Types', 'id_pok', 'id_pok');
    }
    public function stats(){
    	return $this->hasOne('App\Models\Stats', 'pokemon_id', 'id_pok');
    }
    public function weaknesses(){
    	return $this->hasOne('App\Models\Weaknesses', 'pokedex_id', 'id_pok');
    }
    public function evolutions(){
    	return $this->hasOne('App\Models\Evolutions', 'id_pok_base', 'id_pok');
    }
}
