<template>
    <nav class="navbar">
        <router-link class="navbar__logo" to="/">LARAVEL</router-link>
        <ul class="navbar__list">
            <li v-if="isLogin" class="navbar__item">
                <router-link to="/logout">Logout</router-link>
            </li>
            <li v-if="isLogin" class="navbar__item">
                {{ username }}
            </li>
            <li v-else>
                <router-link to="/login">Login</router-link>
            </li>
            <li>
                <router-link to="/items">Items</router-link>
            </li>
            <li v-if="isLogin">
                <router-link to="/items/create">ItemCreate</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    computed: {
        isLogin() {
            return this.$store.getters['auth/check']
        },
        username() {
            return this.$store.getters['auth/username']
        }
    }
}
</script>