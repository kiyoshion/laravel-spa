<template>
    <div>
        <header class="header">
            <Navbar />
        </header>
        <main>
            <div class="container">
                <verified-component />
                <router-view />
            </div>
        </main>
        <Footer />
    </div>
</template>

<script>
import Navbar from './components/Navbar'
import Footer from './components/Footer'
import VerifiedComponent from './components/VerifiedComponent'
import { FORBIDDEN, INTERNAL_SERVER_ERROR } from './util'

export default {
    components: {
        Navbar,
        Footer,
        VerifiedComponent
    },
    computed: {
        errorCode() {
            return this.$store.state.error.code
        }
    },
    watch: {
        errorCode: {
            handler (val) {
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500')
                } else if (val === FORBIDDEN) {
                    this.$router.push('/403')
                }
            },
            immediate: true
        },
        $route () {
            this.$store.commit('error/setCode', null)
        }

    }
}
</script>