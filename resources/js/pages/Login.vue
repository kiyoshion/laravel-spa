<template>
    <div class="">
        <div class="tab">
            <div
                class="tab__item"
                :class="{ 'tab__item--active': tab === 1 }"
                @click="tab = 1">
                Login
            </div>
            <div
                class="tab__item"
                :class="{ 'tab__item--active': tab === 2 }"
                @click="tab = 2">
                Register
            </div>
        </div>
        <div 
            class="tab__content"
            v-show="tab === 1">
            <form class="form" @submit.prevent="login">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="loginForm.email">
                <label for="password">Password</label>
                <input type="password" id="password" v-model="loginForm.password">
                <button type="submit">Login</button>
            </form>
        </div>
        <div 
            class="tab__content"
            v-show="tab === 2">
            <form class="form" @submit.prevent="register">
                <label for="name">Name</label>
                <input type="text" id="name" v-model="registerForm.name">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="registerForm.email">
                <label for="password">Password</label>
                <input type="password" id="password" v-model="registerForm.password">
                <label for="password-confirmation">Password (Confirm)</label>
                <input type="password" id="password-confirmation" v-model="registerForm.password_confirmation">
                <button type="submit">Register</button>
            </form>
        </div>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            tab: 1,
            loginForm: {
                email: '',
                password: ''
            },
            registerForm: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    methods: {
        async login() {
            await this.$store.dispatch('auth/login', this.loginForm)
            this.$router.push('/')
        },
        async register() {
            await this.$store.dispatch('auth/register', this.registerForm)
            this.$router.push('/')
        }
    }
}
</script>