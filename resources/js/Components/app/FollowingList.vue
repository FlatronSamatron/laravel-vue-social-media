<script setup>

import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import FriendItem from "@/Components/app/FollowingItem.vue";

const searchKeyWord = ref('');
</script>

<template>
  <div class="bg-white rounded-lg border shadow pt-3">
    <h2 class="text-2xl font-bold px-3 mb-4">My Friends</h2>
    <div class="px-3">
      <TextInput model-value="" placeholder="Search" class="w-full"/>
      <div class="py-8">
        <div v-if="false" class="text-gray-400 flex text-center p-3">
          You don't have friends yet
        </div>
        <div v-else class="max-h-[calc(100vh-260px)] overflow-y-auto">
          <FriendItem
              image="https://picsum.photos/100"
              title="Oleg Silicon"
          />

          <FriendItem
              image="https://picsum.photos/100"
              title="Semen Brusnika"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
