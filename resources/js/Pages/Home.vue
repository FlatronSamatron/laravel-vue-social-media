<script setup>
import {Head} from '@inertiajs/vue3';
import GroupList from "@/Components/app/GroupList.vue";
import FollowerList from "@/Components/app/FollowingList.vue";
import CreatePost from "@/Components/app/CreatePost.vue";
import PostList from "@/Components/app/PostList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
  posts: Object
})

</script>

<template>
  <Head title="Social media website"/>
  <AuthenticatedLayout>
    <div class="grid lg:grid-cols-12 gap-3 p-3">
    <div class="lg:col-span-3 lg:order-1">
      <GroupList/>
    </div>
    <div class="lg:col-span-3 lg:order-3">
      <FollowerList/>
    </div>
    <div class="lg:col-span-6 lg:order-2">
      <CreatePost/>
      <PostList :posts="posts.data"/>
    </div>
  </div>
  </AuthenticatedLayout>

</template>

<style>

</style>
