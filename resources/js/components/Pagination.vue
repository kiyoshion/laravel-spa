<template>
    <div>
        <router-link
            v-if="! isFirstPage"
            :to="`/items/?page=${currentPage - 1}`"
            >&laquo; prev
        </router-link>
        <router-link
            v-if="! isLastPage"
            :to="`/items/?page=${currentPage + 1}`"
            >next &raquo;
            </router-link>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number
        },
        lastPage: {
            type: Number
        }
    },
    computed: {
        isFirstPage() {
            return this.currentPage === 1
        },
        isLastPage() {
            return this.currentPage === this.lastPage
        }
    }
}
</script>