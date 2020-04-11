<template>
    <div>
        <div>
            <div class="user__avatar">
                <img :src="$store.state.auth.user.avatar" alt="">
            </div>
            <div class="user__name">
                <p>{{ name }}</p>
            </div>
            <div class="user__profile">
                <p>{{ profile }}</p>
            </div>
        </div>
        <div>
            <button @click="isEditProfileToggle">プロフィール編集</button>
        </div>
        <div v-if="isEditProfileShow">
            <form class="form" @submit.prevent="sendEditProfile">
                <div>
                    <label class="form__label" for="name">なまえ</label>
                    <input class="form__input" type="text" v-model="name" id="name">
                </div>
                <div>
                    <label class="form__label" for="profile">自己紹介</label>
                    <textarea class="form__input" name="profile" id="profile" cols="30" rows="5" v-model="profile"></textarea>
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
        <div>
            <button @click="imageShowToggle">アバター変更</button>
        </div>
        <div v-if="isImageShow">
            <form @submit.prevent="sendAvatar">
                <label for="file">プロフィール画像</label>
                <input type="file" @change="inputFile">
                <div>
                    <img v-if="uploadImage" class="form__preview" :src="uploadImage" alt="">
                    <img v-else class="form__preview" :src="$store.state.auth.user.avatar" alt="">
                </div>
                <button type="submit">画像設定</button>
                <button @click="imageShowToggle">キャンセル</button>
            </form>

        </div>
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
    data() {
        return {
            items: [],
            currentPage: 0,
            lastPage: 0,
            isEditProfileShow: false,
            isImageShow: false,
            name: '',
            profile: '',
            avatar: '',
            avatarName: '',
            uploadImage: '',
            file: '',
        }
    },
    components: {
        Item,
        Pagination
    },
    methods: {
        async fetchItems() {
            const res = await axios.get('/api/home')
            this.items = res.data.data
            this.currentPage = res.data.current_page
            this.lastPage = res.data.last_page
            if (this.$store.state.auth.user.profile) {
                this.profile = this.$store.state.auth.user.profile
            }
        },
        async sendEditProfile() {
            const res = await axios.post(`/api/user/${this.$store.state.auth.user.id}`, {
                name: this.name,
                profile: this.profile,
            })
            this.$store.dispatch('auth/currentUser', res.data)
            this.isEditProfileShow = !this.isEditProfileShow
        },
        async sendAvatar() {
            const formData = new FormData()
            formData.append('file', this.file)
            const res = await axios.post(`/api/user/${this.$store.state.auth.user.id}/upload`, formData)
            this.$store.dispatch('auth/currentUser', res.data)
            this.isImageShow = !this.isImageShow
        },
        isEditProfileToggle() {
            this.isEditProfileShow = !this.isEditProfileShow
        },
        inputFile(event) {
            this.file = event.target.files[0]
            this.createImage(this.file)
        },
        createImage(file) {
            const reader = new FileReader()
            reader.onload = e => {
                this.uploadImage = e.target.result
            }
            reader.readAsDataURL(file)
        },
        imageShowToggle() {
            this.isImageShow = !this.isImageShow
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchItems()
                this.name = this.$store.state.auth.user.name
            },
            immediate: true
        }
    }
}
</script>

<style lang="scss">
.user {
    &__avatar {
        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    }
}
.form {
    &__preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
}
</style>