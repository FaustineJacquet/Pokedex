<template>
  <div class="hello">
    <div class="container" style="margin-top: 5vh;">
      <div class="row">
        <div  class="col-2" v-for="(result, index) in results" :key="result+index">
          <img style="margin-top: 4vh;" :src="'http://127.0.0.1:8001' +result.image" :title="'image of ' +result.name" height="150vh" wigth="150vw"><br>
          <h2 style="margin-top: 2vh;">{{result.name}}</h2><br>
          <button v-b-modal="'modal'+result.id" v-on:click="getPoke(result.id)" style="margin-bottom: 4vh; margin-top: -3vh;"> Show more about {{result.name}}</button>
          <b-modal 
          :id="'modal'+result.id" 
          v-if="pokemon"
          v-bind:title="pokemon.name" 
          >
          <div v-if="pokemon">

            <img style="display: block; margin-left: auto; margin-right: auto;" :src="'http://127.0.0.1:8001' +pokemon.image" :title="'image of ' +pokemon.name"><br>

            <b-card-group>
              <div class="container">
                <b-row>
                  <div class="col-6">
                    <b-card>
                      <h4>Types :</h4>
                      <div>Type 1: {{pokemon.types["type1"]}}</div>
                      <div>Type 2: {{pokemon.types["type2"]}}</div>
                    </b-card>
                  </div>

                  <div class="col-6">
                    <b-card>
                      <h4 style="margin-top: 3vh;">Stats :</h4>
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
                      <h4 style="margin-top: 3vh;">Weaknesses :</h4>
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
                      <h4 style="margin-top: 3vh;">Evolution :</h4>
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
       pokemon: null
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
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
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
</style>
