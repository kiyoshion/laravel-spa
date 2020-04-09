<template>
    <div>
        <h1>Create</h1>
        <form class="form" @submit.prevent="submit">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" v-model="title">
            <label for="body">Body</label>
            <textarea name="body" id="body" cols="30" rows="5" v-model="body"></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            body: '',
            userId: ''
        }
    },
    created() {
    },
    methods: {
        async submit() {
            this.userId = this.userid
            const response = await axios.post('/api/items', {
                title: this.title,
                body: this.body,
                user_id: this.$store.state.auth.user.id
            })
            this.reset()
            this.$router.push(`/items/${response.data.id}`)
        },
        reset() {
            this.title = null
            this.body = null
        }
    }
}
</script>