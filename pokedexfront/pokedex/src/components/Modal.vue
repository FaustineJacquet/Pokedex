<template>
  <div>
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
                <div v-for="(type, name) in pokemon.types" :key="type+name">
                  {{name}} : {{type}}
                </div>
              </b-card>
            </div>

            <div class="col-6">
              <b-card>
                <h5 style="margin-top: 3vh;">Stats :</h5>
                <div v-for="(stat, name) in pokemon.stats" :key="stat+name">
                  {{name}} : {{stat}}
                </div>
              </b-card>
            </div>

            <div class="col-6" style="margin-top: 3vh;">
              <b-card>
                <h5 style="margin-top: 3vh;">Weaknesses :</h5>
                <div v-for="(weakness,name) in pokemon.weaknesses" :key="weakness+name">
                  {{name}} : {{weakness}}
                </div>
              </b-card>
            </div>

            <div class="col-6" style="margin-top: 3vh;">
              <b-card v-if="pokemon.evolutions.length !== 0">
                <h5 style="margin-top: 3vh;">Evolution :</h5>
                <div v-for="(evolution, name) in pokemon.evolutions" :key="evolution+name">
                  {{name}} : {{evolution}}
                </div>
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

</template>

<script>
  export default {
    name: 'modal',
    props:{
      result: Object
    },
    data: function(){
      return{
       evolutions: [],
       pokemon: null,
     } 
   },
   mounted(){
    this.getPoke()
  },
  methods:
  {
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
.cardpokemons{
 display: block;
 margin: auto;
}
</style>
