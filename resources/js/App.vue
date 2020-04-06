<template>
    <div>
        <header class="header">
            <Navbar />
        </header>
        <main>
            <div class="container">
                <router-view />
            </div>
        </main>
        <Footer />
    </div>
</template>

<script>
import Navbar from './components/Navbar'
import Footer from './components/Footer'

export default {
    components: {
        Navbar,
        Footer
    }    
}
</script>