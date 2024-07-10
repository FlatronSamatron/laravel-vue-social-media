<script setup>
import {onMounted, onUnmounted, ref} from "vue";

import {
  ChevronLeftIcon, ChevronRightIcon
} from '@heroicons/vue/24/outline'
import {DocumentIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";

const {show, files, fileIndex} = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  files: Array,
  fileIndex: Number
});

const emit = defineEmits(['close'])

const isArrow = files.length > 1

const currentFile = ref({
  index: fileIndex,
  file: files[fileIndex]
})

const closeOnEscape = (e) => {
  if (e.key === 'Escape' && show) {
    emit('close');
  }
};

const next = () => {
  const {index} = currentFile.value
  let nextIndex = index + 1 !== files.length ? index + 1 : 0

  currentFile.value = {
    index: nextIndex,
    file: files[nextIndex]
  }
}

const previous = () => {
  const {index} = currentFile.value
  let previousIndex = index - 1 < 0 ? files.length - 1 : index - 1

  currentFile.value = {
    index: previousIndex,
    file: files[previousIndex]
  }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape);
  document.body.style.overflow = null;
});

const isImage = (type) => {
  return type.toLowerCase().includes('image')
}

</script>

<template>
  <Transition leave-active-class="duration-200">
    <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-40">
      <XMarkIcon class="z-50 absolute right-2 top-2 size-8 cursor-pointer text-white transition-all hover:scale-150" @click="emit('close')"/>
      <Transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
      >
        <div v-show="show" class="fixed inset-0 transform transition-all flex justify-center items-center">
          <div class="absolute inset-0 bg-gray-500 opacity-75"/>
          <div class="z-50 flex  items-center w-full" :class="isArrow ? 'justify-between' : 'justify-center'">
            <ChevronLeftIcon @click="previous" v-if="isArrow" class="size-14 cursor-pointer transition-all hover:scale-150 text-white"/>
            <img v-if="isImage(currentFile.file.mime)" :src="currentFile.file.url" alt="image" class="select-none">
            <div v-else class="aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500 w-full" >
              <DocumentIcon class="size-16"/>

              <small class="text-center">{{ currentFile.file.name }}</small>
            </div>
            <ChevronRightIcon @click="next" v-if="isArrow" class="size-14 cursor-pointer transition-all hover:scale-150 text-white"/>
          </div>
        </div>
      </Transition>
    </div>
  </Transition>
</template>

<style scoped>

</style>