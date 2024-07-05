<script setup>
    import {ref} from "vue";
    import PostModal from "@/Components/app/PostModal.vue";
    const isModalOpen = ref(false)
</script>

<template>
    <div class="bg-white rounded-lg border shadow p-3 mb-3 flex gap-1 flex-1 items-center justify-center bg-gray-100 hover:bg-gray-200 transition-all rounded-lg py-3 cursor-pointer text-xl font-bold" @click="isModalOpen=true">
      Click here to create new post
      <PostModal v-if="isModalOpen" :isModalOpen="isModalOpen" @closeModal="isModalOpen=false"/>
    </div>
</template>

<style scoped>

</style>
