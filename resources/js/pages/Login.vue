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
            <div
                class="tab__item"
                :class="{ 'tab__item--active': tab === 3 }"
                @click="tab = 3">
                パスワードリセット
            </div>
        </div>
        <div 
            class="tab__content"
            v-show="tab === 1">
            <form class="form" @submit.prevent="login">
                <div class="error" v-if="hasError">
                    <span v-html="errorMessage"></span>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" v-model="loginForm.email">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" v-model="loginForm.password">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
        <div 
            class="tab__content"
            v-show="tab === 2">
            <form class="form" @submit.prevent="register">
                <div v-if="errorsRegister.length">
                    <ul>
                        <li v-for="(error, index) in errorsRegister" :key="index">
                            {{ error }}
                        </li>
                    </ul>
                </div>
                <div>
                    <label for="name">Name</label>
                    <input type="text" id="name" v-model="registerForm.name">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" v-model="registerForm.email">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" v-model="registerForm.password">
                </div>
                <div>
                    <label for="password-confirmation">Password (Confirm)</label>
                    <input type="password" id="password-confirmation" v-model="registerForm.password_confirmation">
                </div>
                <button type="submit">Register</button>
            </form>
        </div>
        <div
            class="tab__content"
            v-show="tab === 3">
            <form @submit.prevent="sendEmail">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" v-model="email">
                <button type="submit">送信</button>
            </form>
            <div v-if="passwordResetMessage">
                <p v-html="passwordResetMessage"></p>
            </div>
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
            },
            hasError: false,
            hasErrorForRegister: false,
            errorMessage: '',
            errorsRegister: [],
            email: '',
            passwordResetMessage: '',
        }
    },
    computed: {
        status () {
            return this.$store.state.auth.status
        }
    },
    methods: {
        async login() {
            await this.$store.dispatch('auth/login', this.loginForm)
            if (this.status) {
                this.$router.push('/')
            } else {
                if (this.$store.state.error.code === 422) {
                    this.hasError = true
                    this.errorMessage = 'メールアドレスもしくはパスワードが違います。'
                }
            }
        },
        async register() {
            this.errorsRegister = []

            if (!this.registerForm.name) {
                this.hasErrorForRegister = true
                this.errorsRegister.push('名前を入力してください。')
                return false
            } else if (!this.registerForm.email) {
                this.errorsRegister.push('メールアドレスを入力してください。')
                return false
            } else if (!this.validEmail(this.registerForm.email)) {
                this.errorsRegister.push('正しいメールアドレスを入力してください。')
                return false
            } else if (!this.registerForm.password) {
                this.errorsRegister.push('パスワードを入力してください。')
                return false
            } else if (this.registerForm.password.length < 8) {
                this.errorsRegister.push('パスワードは8文字以上で設定してください。')
                return false
            } else if (!this.registerForm.password_confirmation) {
                this.errorsRegister.push('確認用パスワードを入力してください。')
                return false
            } else if (this.registerForm.password !== this.registerForm.password_confirmation) {
                this.errorsRegister.push('パスワードと確認用パスワードが一致しません。')
                return false
            }

            await this.$store.dispatch('auth/register', this.registerForm)
            this.$router.push('/')
        },
        async sendEmail() {
            const response = await axios.post('/api/password/email', {
                email: this.email
            }).then(e => {
                this.passwordResetMessage = this.email + 'にメールを送信しました。<br>メール本文のURLからパスワードをリセットしてください。'
                this.email = ''
            }).catch(e => {
                this.passwordResetMessage = 'メールアドレスが正しくありません。<br>メールアドレスを確認してください。'
                return false
            })
        },
        validEmail(email) {
            let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return re.test(email)
        }
    }
}
</script>