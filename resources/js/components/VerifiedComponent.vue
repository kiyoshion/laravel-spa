<template>
    <div>
        <div v-if="!checkVerified">
            <p>メール認証を完了させてください。<br>7日を過ぎると該当のメールアドレスで登録できなくなります。</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            checkVerified: false
        }
    },
    computed: {
        isLogin() {
            return this.$store.getters['auth/check']
        },
        isVerified() {
            return this.$store.getters['auth/checkVerified']
        },
    },
    created() {
        this.checkVerifiedStatus()
    },
    methods: {
        checkVerifiedStatus() {
            if (this.isLogin == false) {
                this.checkVerified = true
            } else if (this.isLogin == true && this.isVerified == false) {
                this.checkVerified = false
            } else {
                this.checkVerified = true
            }
        }
    }
}
</script>