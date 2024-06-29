<script setup>
import PostItem from "@/Components/app/PostItem.vue";

defineProps({
  posts: Object
})

</script>

<template>
  <div class="max-h-[calc(100vh-180px)] overflow-y-auto">
    <PostItem v-for="post of posts" :key="post.id" :post="post"/>
  </div>
</template>

<style
    scoped>

</style>
