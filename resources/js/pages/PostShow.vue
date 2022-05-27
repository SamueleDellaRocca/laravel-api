<template>
  <div>
        <div>
            <h1>{{ post.title }}</h1>
            <b>From {{ post.user.name }}<span v-if="post.category"> in category {{ post.category.name }}</span></b>
            <div class="tags">
                <span v-for="tag in post.tags" :key="tag.id" class="tag">{{ tag.name }}</span>
            </div>
            <p>{{ post.content }}</p>
        </div>
  </div>
</template>

<script>
export default {
name: 'PostShow',
props: ['slug'],
 data() {
        return {
            is404: false,
            post: null,
            baseApiUrl: 'http://localhost:8000/api/posts',
        }
    },
    created() {
        this.getData(this.baseApiUrl + '/' + this.slug);
    },
    methods: {
        getData(url) {
            if (url) {
                Axios.get(url)
                .then(res => {
                    if (res.data.success) {
                        this.post =  res.data.response.data;
                    } else {
                        //this.$router.replace({name: 'page404'}); //TODO: fare in modo che non modifica l'url (Risolto ma credo si puo' fare di meglio)
                        this.is404 = true;
                    }
                });
            }
        }
    }
}
</script>

<style>

</style>