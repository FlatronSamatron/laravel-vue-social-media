<script setup>
const props = defineProps({
  attachmentFiles: Array,
  deletedFileIds: {
    type: Array,
    default: []
  },
  isPost: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['removeFile', 'removeFromDeleted'])

import {DocumentIcon, XMarkIcon, ArrowUturnLeftIcon, ArrowDownTrayIcon} from "@heroicons/vue/24/outline/index.js";
const isImage = (type) => {
  return type.toLowerCase().includes('image')
}

</script>

<template>
  <div class="grid gap-3 mt-3 mb-3" :class="[
        attachmentFiles.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
      ]">
    <div v-for="attachment of attachmentFiles" class="relative group bg-gray-100 flex justify-center">
      <div v-if="attachment.deleted && !props.isPost" class="absolute left-0 bottom-0 bg-black/50 text-white p-2 w-full h-full flex justify-center items-center text-2xl">
        To be deleted
        <ArrowUturnLeftIcon class="absolute size-6 top-2 right-2 cursor-pointer hover:scale-110 transition-all" @click="emit('removeFromDeleted', attachment)"/>
      </div>

      <div class="absolute top-2 right-2 cursor-pointer opacity-0 group-hover:opacity-100 transition-all hover:scale-110">
        <a :href="route('post.download', attachment)">
          <ArrowDownTrayIcon v-if="props.isPost" class="size-8 bg-gray-600 rounded text-gray-100 cursor-pointer p-2 hover:bg-gray-800 transition-all"/>
        </a>
        <XMarkIcon v-if="!attachment.deleted && !props.isPost" class="size-6" @click="emit('removeFile', attachment)"/>
      </div>

      <img class="object-contain" v-if="isImage(attachment.mime)" :src="attachment.url" alt="">
      <div v-else class="aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500" >
        <DocumentIcon class="size-16"/>

        <small class="text-center">{{ attachment.name }}</small>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>