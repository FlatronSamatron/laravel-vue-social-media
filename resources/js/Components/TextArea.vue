<script setup>

import {ref} from "vue";

const props = defineProps({
  placeholder: String,
  autoresize: {
    type: Boolean,
    default: true
  }
});

const model = defineModel()
const textarea = ref(null)

const onInput = () => {
  if(props.autoresize){
    textarea.value.style.height = 'auto'
    textarea.value.style.height = textarea.value.scrollHeight + 'px'
  }
}

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
