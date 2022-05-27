<template>
  <div>
        <div class="container-fluid">
            <h1 class="text-center">I Quattro post più in voga al momento</h1>
            <div class="row justify-content-center row-cols-2">
                <div class="col-5 mb-3" v-for="post in posts" :key="post.id">
                    <div class="card h-100">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ post.title }}</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a :href="'/posts/' + post.slug" class="btn btn-primary mt-auto">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
export default {
name: 'PageHome',
data() {
        return {
            posts: [],
            baseApiUrl: 'http://localhost:8000/api/posts/?home',
        }
    },
    created() {
        this.getData(this.baseApiUrl);
    },
    methods: {
        getData(url) {
            if (url) {
                Axios.get(url)
                .then(res => {
                    this.posts =  res.data.response.data;
                });
            }
        }
    }
}
</script>

<style>

</style>