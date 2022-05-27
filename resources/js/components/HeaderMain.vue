<template>
  <div class="text-center d-flex justify-content-center gap-4">
      <h1><router-link :to="{name:'home'}">Home</router-link></h1>
      <h1><router-link :to="{name:'about'}">About</router-link></h1>
      <h1><router-link :to="{name:'postIndex'}">Blog</router-link></h1>
  </div>
</template>

<script>
export default {
name: 'HeaderMain',

data() {
    return {

    }
}
}
</script>

<style>

</style>