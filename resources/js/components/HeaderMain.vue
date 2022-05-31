<template>
  <div class="text-center d-flex justify-content-center gap-5">
      <h1><router-link class="text-decoration-none" :to="{name:'home'}">Home</router-link></h1>
      <h1><router-link class="text-decoration-none" :to="{name:'about'}">About</router-link></h1>
      <h1><router-link class="text-decoration-none" :to="{name:'postIndex'}">Blog</router-link></h1>
      <h1><router-link class="text-decoration-none" :to="{name:'contact'}">Contact Us</router-link></h1>
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