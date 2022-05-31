<template>
  <div>
        <div class="container">
            <h1>{{ post.title }}</h1>
            <b>From {{ post.user.name }}<span v-if="post.category"> in category {{ post.category.name }}</span></b>
            <div class="tags">
                <span v-for="tag in post.tags" :key="tag.id" class="tag">{{ tag.name }}-</span>
            </div>
            <img v-show="post.post_image !== 'http://localhost:8000/storage' " :src="post.post_image" :alt="post.title" class="img-fluid">
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
            post: null,
            baseApiUrl: 'http://localhost:8000/api/posts',
        }
    },
    created() {
        this.getData(this.baseApiUrl + '/' + this.slug);
        console.log(this.slug);
    },
    methods: {
        getData(url) {
            if (url) {
                Axios.get(url)
                .then(res => {
                    if (res.data.success) {
                        this.post =  res.data.response.data;
                    }
                });
            }
        }
    }
}
</script>

<style>

</style>