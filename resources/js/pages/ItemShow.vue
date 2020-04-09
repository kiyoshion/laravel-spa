<template>
    <div>
        <h1>{{ item.title }}</h1>
        <p>{{ item.body }}</p>
        <button
            :class="{ 'btn--liked': item.liked_by_user }"
            @click="onLikeClick"
        >Like</button>
        <div v-if="isLogin" class="comment__form">
            <form @submit.prevent="storeComment">
                <label for="body">Commnet</label>
                <textarea name="body" id="body" cols="30" rows="5" v-model="body"></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
        <div class="comment__list">
            <h3>Comments</h3>
            <div v-for="comment in item.comments" :key="comment.id" class="comment__item">
                <div class="comment__body">{{ comment.body }}</div>
                <div class="comment__user">by {{ comment.user.name }}</div>
            </div>
        </div>
        <router-link to="/items">back</router-link>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            required: true
        }
    },
    computed: {
        isLogin() {
            return this.$store.getters['auth/check']
        },
    },
    data() {
        return {
            item: [],
            comments: [],
            body: '',
            item_id: 1,
        }
    },
    methods: {
        async fetchItem () {
            const res = await axios.get(`/api/items/${this.id}`)
            console.log(res.data)
            this.item = res.data
            this.item_id = res.data.id
        },
        async storeComment() {
            const res = await axios.post(`/api/items/${this.id}/comments`, {
                body: this.body,
                item_id: this.item_id
            })
            this.body = ''
            this.item.comments.unshift(res.data)
        },
        onLikeClick () {
            if (!this.isLogin) {
                alert('ログインしてください')
                return false
            }

            if (this.item.liked_by_user) {
                this.unlike()
            } else {
                this.like()
            }
        },
        async like () {
            const res = await axios.put(`/api/items/${this.id}/like`)
            this.item.likes_count = this.item.likes_count + 1
            this.item.liked_by_user = true
        },
        async unlike () {
            const res = await axios.delete(`/api/items/${this.id}/like`)
            this.item.likes_count = this.item.likes_count - 1
            this.item.liked_by_user = false
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchItem()
            },
            immediate: true
        }
    }
}
</script>

<style lang="scss">
.btn--liked {
    background-color: #ff0000;
} 
</style>