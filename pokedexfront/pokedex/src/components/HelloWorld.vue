<template>
  <div class="hello">
    <pokemon></pokemon>
  </div>
</template>

<script>
  import pokemon from './Pokemon.vue'
  export default {
    name: 'HelloWorld',
    props:{
      msg:String
    },
    components: {
      pokemon
    },
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
