<template>
  <div class="hello">
    <div>
      <b-dropdown variant="light" style="margin-top: 3vh; border: solid 1px" :text="type">
        <b-dropdown-item @click="setType('type')">all</b-dropdown-item>
        <b-dropdown-item v-for="type in types" :key="type" @click="setType(type)">{{type}}</b-dropdown-item>
      </b-dropdown>
    </div>

    <input type="string" name="search" class="searchbar" placeholder="search a pokemon" v-model="search">
    <img src="../assets/ball.jpg" height="100vh" wigth="100vw" style="margin-bottom: 3vh; margin-left: 2vw;">
    <div class="container" style="margin-top: 5vh;">
      <div class="row">
        <div class="cardpokemons" v-for="(result, index) in getresults()" :key="result+index">

          <img style="margin-top: 4vh;" :src="'http://127.0.0.1:8001' +result.image" :title="'image of ' +result.name" height="150vh" wigth="150vw"><br>
          <h2 style="margin-top: 2vh;">{{result.name}}</h2><br>
          <button v-b-modal="'modal'+result.id" v-on:click="getPoke(result.id)" style="margin-bottom: 4vh; margin-top: -3vh;"> Show more <br> about {{result.name}}</button>
          <b-modal 
          :id="'modal'+result.id" 
          :title="pokemon? pokemon.name : ''"
          @hide="pokemon=null"
          >

          <div v-if="pokemon">
            <img class="cardpokemons" :src="'http://127.0.0.1:8001' +pokemon.image" :title="'image of ' +pokemon.name" height="300vh" wigth="300vw"><br>

            <b-card-group>
              <div class="container">
                <b-row>
                  <div class="col-6">
                    <b-card>
                      <h5>Types :</h5>
                      <div>Type 1: {{pokemon.types["type1"]}}</div>
                      <div>Type 2: {{pokemon.types["type2"]}}</div>
                    </b-card>
                  </div>

                  <div class="col-6">
                    <b-card>
                      <h5 style="margin-top: 3vh;">Stats :</h5>
                      <div>hp: {{pokemon.stats["hp"]}}</div>
                      <div>attack: {{pokemon.stats["attack"]}}</div>
                      <div>defense: {{pokemon.stats["defense"]}}</div>
                      <div>sp_attack: {{pokemon.stats["sp_attack"]}}</div>
                      <div>sp_defense: {{pokemon.stats["sp_defense"]}}</div>
                      <div>speed: {{pokemon.stats["speed"]}}</div>
                    </b-card>
                  </div>

                  <div class="col-6" style="margin-top: 3vh;">
                    <b-card>
                      <h5 style="margin-top: 3vh;">Weaknesses :</h5>
                      <div>Bug: {{pokemon.weaknesses["bug"]}}</div>
                      <div>Dragon: {{pokemon.weaknesses["dragon"]}}</div>
                      <div>Electric: {{pokemon.weaknesses["electric"]}}</div>
                      <div>Fairy: {{pokemon.weaknesses["fairy"]}}</div>
                      <div>Fight: {{pokemon.weaknesses["fight"]}}</div>
                      <div>Fire: {{pokemon.weaknesses["fire"]}}</div>
                      <div>Flying: {{pokemon.weaknesses["flying"]}}</div>
                      <div>Ghost: {{pokemon.weaknesses["ghost"]}}</div>
                      <div>Grass: {{pokemon.weaknesses["grass"]}}</div>
                      <div>Ground: {{pokemon.weaknesses["ground"]}}</div>
                      <div>Ice: {{pokemon.weaknesses["ice"]}}</div>
                      <div>Normal: {{pokemon.weaknesses["normal"]}}</div>
                      <div>Poison: {{pokemon.weaknesses["poison"]}}</div>
                      <div>Psychic: {{pokemon.weaknesses["psychic"]}}</div>
                      <div>Rock: {{pokemon.weaknesses["rock"]}}</div>
                      <div>Steel: {{pokemon.weaknesses["steel"]}}</div>
                      <div>Water: {{pokemon.weaknesses["water"]}}</div>
                    </b-card>
                  </div>

                  <div class="col-6" style="margin-top: 3vh;">
                    <b-card v-if="pokemon.evolutions.length !== 0">
                      <h5 style="margin-top: 3vh;">Evolution :</h5>
                      <div>Id_pok_evolu : {{pokemon.evolutions["id_pok_evol"]}}</div>
                      <div>Lvl_evol_pok : {{pokemon.evolutions["lvl_evol_pok"]}}</div>
                      <div style="margin-top: 6vh; font-weight: bold; font-size: 1rem;">Next evolution :</div>
                      <button><img @click="getPoke(evolutions.id)" :src="'http://127.0.0.1:8001' +evolutions.image" :title="'image of ' +evolutions.name" class="icon"></button>
                    </b-card>
                  </div>


                </b-row>
              </div>
            </b-card-group>
          </div>
        </b-modal>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  export default {
    name: 'HelloWorld',
    props: {
      msg: String
    },
    data: function(){
      return{
       results: [], 
       evolutions: [],
       search: '',
       pokemon: null,
       types: [],
       type: 'type'
     } 
   },
   mounted(){
    this.getPokemon()
  },
  methods:
  {
    getPokemon(){
      fetch('http://127.0.0.1:8001/', {
        method: "GET"
      })
      .then(response => response.json())
      .then(response => {
        console.log(response)
        this.results=response
        this.getType()
      })
    },
    getPoke(id){
      fetch('http://127.0.0.1:8001/pokemon/'+id, {
        method: "GET"
      })
      .then(response => response.json())
      .then(response => {
        console.log(response)
        this.pokemon=response.note
        if(this.pokemon.evolutions.length !== 0){
          this.getEvolution(this.pokemon.evolutions.id_pok_evol);
        }
      })
    },
    getEvolution(id){
      fetch('http://127.0.0.1:8001/pokemon/'+id, {
        method: "GET"
      })
      .then(response => response.json())
      .then(response => {
        console.log(response)
        this.evolutions=response.note
      })
    },
    similar(id, name, types){
      var search = this.search.toLowerCase();
      id=id.toString().toLowerCase();
      name=name.toLowerCase();
      let type1=types.type1.toLowerCase();
      let type2=types.type2.toLowerCase();

      if(id.includes(search) || name.includes(search) || type1.includes(search) || type2.includes(search)){
        return true;
      } 
      return false;
    },
    getresults(){
      var filteredresults = [];
      for(var i=0; i<this.results.length; i++){
        let pokemon = this.results[i];
        if (this.similar(pokemon.id, pokemon.name, pokemon.types) && this.same(pokemon.types)) {
          filteredresults.push(pokemon);
        }
      }
      return filteredresults;
    },
    same(types){
      if(this.type==="type"){
        return true;
      }

      let type1=types.type1.toLowerCase();
      let type2=types.type2.toLowerCase();

      if(type1==this.type || type2==this.type){
        return true;
      } 
      return false;
    },
    setType(type){
      this.type=type;
    },
    getType(){
      this.types=[];
      for(var i=0; i<this.results.length; i++){
        var pokemon=this.results[i]
        let type1=pokemon.types.type1.toString()
        let type2=pokemon.types.type2.toString()
        if (!this.types.includes(type1)) {
          this.types.push(type1);
        } if (!this.types.includes(type2) && type2!=="") {
          this.types.push(type2);
        }
      } 
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
h5 {
  font-weight: bold;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.icon {
  display: block;
  margin: auto;
  width: 4em;
  height: 4em;
}
.searchbar{
  margin-top: 4vh;
  margin-bottom: -2vh;
}
.cardpokemons{
 display: block;
 margin: auto;
}
</style>
