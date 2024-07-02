<script setup>
import {computed, ref} from "vue";

const props = defineProps({
  text: String
})

const TEXT_LENGTH = 75

const isOpenRef = ref(false);
const isLong = props.text.length > TEXT_LENGTH

const textValue = computed(()=> !isOpenRef.value && isLong ? props.text.slice(0, TEXT_LENGTH) + '...' : props.text)

const toggle = () => {
  isOpenRef.value = !isOpenRef.value
}

</script>

<template>
  <div v-html="textValue"></div>
  <small v-if="isLong" @click="toggle" class="text-blue-500 cursor-pointer transition-all hover:underline">
    {{ isOpenRef ? 'Read less' : 'Read more' }}
  </small>
</template>

<style scoped>

</style>