<template>
  <div>
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

          <modal
          :result= "result"
          ></modal>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import modal from './Modal.vue'
  export default {
    name: 'pokemon',
    components: {
      modal
    },
    data: function(){
      return{
       results: [], 
       search: '',
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
