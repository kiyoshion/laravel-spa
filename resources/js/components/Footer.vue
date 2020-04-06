<template>
    <footer class="footer">
        <button v-if="isLogin" @click="logout">Logout</button>
        <router-link v-else to="/login">Login</router-link>
    </footer>
</template>

<script>
export default {
    computed: {
        isLogin() {
            return this.$store.getters['auth/check']
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch('auth/logout')
            this.$router.push('/login')
        },
    }
}
</script>