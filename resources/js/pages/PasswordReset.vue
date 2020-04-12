<template>
    <div>
        <form @submit.prevent="sendPasswordReset">
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" v-model="email">
            </div>
            <div>
                <label for="password">新しいパスワード</label>
                <input type="password" name="password" id="password" v-model="password">
            </div>
            <div>
                <label for="password_confirmation">新しいパスワード確認</label>
                <input type="password" name="password_confirmation" id="password_confirmation" v-model="password_confirmation">
            </div>
            <button type="submit">送信</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            password_confirmation: '',
        }
    },
    computed: {
        status () {
            return this.$store.state.auth.status
        }
    },
    mounted() {
        this.setEmail()
    },
    methods: {
        async sendPasswordReset() {
            const response = await axios.post('/api/password/reset', {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                token: this.$route.params.token
            })
            await this.$store.dispatch('auth/login', this.loginForm)
            if (this.status) {
                this.$router.push('/home')
            }
        },
        setEmail () {
            this.email = this.$route.query.email
        }
    }
}
</script>