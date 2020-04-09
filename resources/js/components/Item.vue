<template>
    <div class="item">
        <h2>{{ item.title }}</h2>
        <p>username: {{ item.user.name }}</p>
        <p>{{ item.body }}</p>
        <router-link
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