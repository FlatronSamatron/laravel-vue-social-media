<script setup>
import {computed, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {DocumentIcon, XMarkIcon} from "@heroicons/vue/24/outline";

const props = defineProps({
  isModalOpen: Boolean,
  isCreatePost: {
    default: false,
    type: Boolean
  }
})

const emit = defineEmits(['closeModal'])

const editor = ClassicEditor
const editorConfig = {
  toolbar: [
    "bold", "italic", "|", "bulletedList", "numberedList", '|', "link",   "blockQuote", "heading", "undo", "redo"
  ],
}

const isModalOpen = ref(false)
const attachmentFiles = ref([]);

const form = useForm({
  body: '',
  attachments: []
})

const submit = () => {
  form.attachments = attachmentFiles.value.map( f => f.file)

  if(!form.body.length){
    isModalOpen.value = false
    return
  }

  if(props.isCreatePost){
    form.post(route('post.create'), {
      onSuccess: () => {
        form.reset()
        emit('closeModal')
      }
    })
  }

}

const isImage = (type) => {
  return type.toLowerCase().includes('image')
}

const removeFile = (attach) => {
  attachmentFiles.value = attachmentFiles.value.filter(f => f !== attach)
}

const onAttachmentChoose = async (e) => {
  const files = e.target.files
  for(const file of files){
    const myFile = {
      file,
      url: await readFile(file)
    }
    attachmentFiles.value.push(myFile)
  }
  e.target.files = null
}

const readFile = async (file) => {
  return new Promise((res, rej) => {
    if(isImage(file.type)){
      const reader = new FileReader();
      reader.onload = () => {
        res(reader.result)
      }
      reader.onerror = rej
      reader.readAsDataURL(file)
    } else {
      res(null)
    }
  })
}
</script>

<template>
  <Modal :show="props.isModalOpen" @close="emit('closeModal')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
        Create Post
      </h2>

      <div class="mt-6">
        <ckeditor :editor="editor" v-model="form.body" :config="editorConfig"></ckeditor>
      </div>

      <div class="grid gap-3 mt-3 mb-3" :class="[
        attachmentFiles.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
      ]">
        <div v-for="attachment of attachmentFiles" class="relative group bg-blue-100 flex justify-center">
          <XMarkIcon class="size-6 absolute top-2 right-2 cursor-pointer opacity-0 group-hover:opacity-100 transition-all hover:scale-110" @click="removeFile(attachment)"/>
          <img class="object-contain" v-if="isImage(attachment.file.type)" :src="attachment.url" alt="">
          <div v-else class="aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500" >
            <DocumentIcon class="size-16"/>

            <small class="text-center">{{ attachment.file.name }}</small>
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-between">
        <SecondaryButton @click="isModalOpen=false"> Cancel</SecondaryButton>

        <div>
          <SecondaryButton
              class="ms-3 relative"
              @click=""
          >
            Attach Files
            <input @change="onAttachmentChoose" type="file" multiple class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
          </SecondaryButton>
          <PrimaryButton
              class="ms-3"
              @click="submit"
          >
            Create Post
          </PrimaryButton>
        </div>
      </div>
    </div>
  </Modal>
</template>

<style scoped>

</style>
