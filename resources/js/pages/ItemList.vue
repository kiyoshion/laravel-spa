<template>
    <div>
        <Item
            v-for="(item, index) in items"
            :key="index"
            :item="item"
            :id="item.id"
        />
        <Pagination
            :current-page="currentPage"
            :last-page="lastPage" />
    </div>
</template>

<script>
import Item from '../components/Item.vue'
import Pagination from '../components/Pagination.vue'

export default {
    props: {
        page: {
            type: Number,
            required: false,
            default: 1
        }
    },
    components: {
        Item,
        Pagination
    },
    data() {
        return {
            items: [],
            currentPage: 0,
            lastPage: 0
        }
    },
    methods: {
        async fetchItems () {
            const res = await axios.get(`/api/items/?page=${this.page}`)
            this.items = res.data.data
            this.currentPage = res.data.current_page
            this.lastPage = res.data.last_page
        },
        onLikeClick({ id, liked }) {
            if (!this.$store.getters['auth/check']) {
                alert('ログインしてください')
                return false
            }
            if (liked) {
                this.unlike(id)
            } else {
                this.like(id)
            }
        },
        async like (id) {
            const res = await axios.put(`/api/items/${id}/like`)
            this.items = this.items.map(item => {
                if (item.id === res.data.item_id) {
                    item.likes_count += 1
                    item.liked_by_user = true
                }
                return item
            })
        },
        async unlike (id) {
            const res = await axios.delete(`/api/items/${id}/like`)
            this.items = this.items.map(item => {
                if (item.id === res.data.item_id) {
                    item.likes_count -= 1
                    item.liked_by_user = false
                }
                return item
            })
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchItems()
            },
            immediate: true
        }
    }
}
</script>