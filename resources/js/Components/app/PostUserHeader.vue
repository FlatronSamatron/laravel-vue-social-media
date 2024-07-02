<script setup>

defineProps({
  avatarPath: String,
  name: String,
  group: String,
  createdAt: String,
})


</script>

<template>
  <div class="flex items-center gap-2">
    <a href="#">
      <img :src="avatarPath" alt="image" class="w-[45px] rounded-full transition-all hover:scale-110">
    </a>
    <div>
      <h4 class="flex font-bold">
        <a href="#" class="transition-all hover:underline">
          {{name}}
        </a>
        <span v-if="group" class="ml-1">
            >
            <a href="#" class="transition-all hover:underline">
              {{group}}
            </a>
          </span>
      </h4>
      <small class="text-gray-400">{{createdAt}}</small>
    </div>
  </div>
</template>

<style scoped>

</style>