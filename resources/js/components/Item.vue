<template>
    <div class="item">
        <h2 class="item__ttl">{{ item.title }}</h2>
        <span class="item__user">by {{ item.user.name }}</span>
        <p class="item__body">{{ item.body }}</p>
        <span class="item__likes-count">likes: {{ item.likes_count }}</span>
        <span class="item__comments-count">comments: {{ item.comments_count }}</span>
        <router-link
            class="item__link"
            :to="`/items/${item.id}`">
            read more</router-link>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object
        }
    },
}
</script>

<style lang="scss" scoped>
h2 {
    display: inline;
}
</style>