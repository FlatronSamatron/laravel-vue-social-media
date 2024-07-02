<script setup>

import {onMounted, ref} from "vue";

const props = defineProps({
  placeholder: String,
  autoresize: {
    type: Boolean,
    default: true
  }
});

const model = defineModel()
const textarea = ref(null)

const autoResize = () => {
  textarea.value.style.height = 'auto'
  textarea.value.style.height = textarea.value.scrollHeight + 'px'
}

const onInput = () => {
  if(props.autoresize){
    autoResize()
  }
}

onMounted(()=>{
  setTimeout(()=>{
    autoResize()
  }, 0)
})

</script>

<template>
    <textarea
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :placeholder="placeholder"
        v-model="model"
        @input="onInput"
        ref="textarea"
    />
</template>
