<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pokemons =  Pokemon::all();
        $data = [];
        foreach ($pokemons as $pokemon) {
            $pokemon_data= [];
            $pokemon_data["id"]=$pokemon->id_pok;
            $pokemon_data["name"]=$pokemon->nom_pok;

            $types=$pokemon->types;
            $types=[
                "type1"=>$types["type1"],
                "type2"=>$types["type2"]
            ];
            $pokemon_data["types"]=$types;

            $num = strval($pokemon->id_pok);
            $len=strlen($num);
            if($len===1){
                $num = "00".$num;
            }
            else if($len===2){
                $num = "0".$num;
            }

            $image= "/storage/pokemon_image/" . $num . ".png";
            $pokemon_data["image"]=$image;
            $data[]=$pokemon_data;
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function show(Pokemon $pokemon)
    {
        $pokemons =  Pokemon::all();
        $data = [];
        $pokemon_data= [];
        $pokemon_data["id"]=$pokemon->id_pok;
        $pokemon_data["name"]=$pokemon->nom_pok;

        $types=$pokemon->types;
        $types=[
            "type1"=>$types["type1"],
            "type2"=>$types["type2"]
        ];
        $pokemon_data["types"]=$types;
        $num = strval($pokemon->id_pok);
        $len=strlen($num);
        if($len===1){
            $num = "00".$num;
        }
        else if($len===2){
            $num = "0".$num;
        }

        $image= "/storage/pokemon_image/" . $num . ".png";
        $pokemon_data["image"]=$image;

        $stats=$pokemon->stats;
        $stats=[
            "hp"=>$stats["hp"],
            "attack"=>$stats["attack"],
            "defense"=>$stats["defense"],
            "sp_attack"=>$stats["sp_attack"],
            "sp_defense"=>$stats["sp_defense"],
            "speed"=>$stats["speed"]
        ];
        $pokemon_data["stats"]=$stats;

        $weaknesses=$pokemon->weaknesses;
        $weaknesses=[
            "bug"=>$weaknesses["bug"],
            "dragon"=>$weaknesses["dragon"],
            "electric"=>$weaknesses["electric"],
            "fairy"=>$weaknesses["fairy"],
            "fight"=>$weaknesses["fight"],
            "fire"=>$weaknesses["fire"],
            "flying"=>$weaknesses["flying"],
            "ghost"=>$weaknesses["ghost"],
            "grass"=>$weaknesses["grass"],
            "ground"=>$weaknesses["ground"],
            "ice"=>$weaknesses["ice"],
            "normal"=>$weaknesses["normal"],
            "poison"=>$weaknesses["poison"],
            "psychic"=>$weaknesses["psychic"],
            "rock"=>$weaknesses["rock"],
            "steel"=>$weaknesses["steel"],
            "water"=>$weaknesses["water"]
        ];
        $pokemon_data["weaknesses"]=$weaknesses;

        $evolutions=$pokemon->evolutions;
        if($evolutions){
            $evolutions=[
                "id_pok_evol"=>$evolutions["id_pok_evol"],
                "lvl_evol_pok"=>$evolutions["lvl_evol_pok"]
            ];
        } else {
            $evolutions=[];
        }

        $pokemon_data["evolutions"]=$evolutions;

        $data["note"]=$pokemon_data;

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function edit(Pokemon $pokemon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pokemon $pokemon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pokemon $pokemon)
    {
        //
    }
}
