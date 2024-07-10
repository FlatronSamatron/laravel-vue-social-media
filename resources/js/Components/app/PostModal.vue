<script setup>
import {computed, ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import AttachmentItems from "@/Components/app/AttachmentItems.vue";

const props = defineProps({
  isModalOpen: Boolean,
  post: Object
})

const attachmentsExtensions = usePage().props.attachmentsExtensions


const {post, isModalOpen} = props

const emit = defineEmits(['closeModal'])
const postErrors = ref([])
const errors = ref([])

const editor = ClassicEditor
const editorConfig = {
  toolbar: [
    "bold", "italic", "|", "bulletedList", "numberedList", '|', "link",   "blockQuote", "heading", "undo", "redo"
  ],
}

const postAttachments = post?.attachments || []

const attachmentFiles = ref([]);
const computedAttachments = computed(() => {
  return [...attachmentFiles.value, ...postAttachments]
});

const form = useForm({
  id: post && post.id,
  body: post?.body || '',
  attachments: [],
  deleted_file_ids: [],
  _method: ''
})

const getErrorsValues = (e) => {
  errors.value = e
  for(let key in e){
    if(key.includes('.')){
      const [_, index] = key.split('.')
      postErrors.value[index] = e[key]
    }
  }
}

const submit = () => {
  form.attachments = attachmentFiles.value.map( f => f.file)
  postErrors.value = []

  if(!post){
    form.post(route('post.create'), {
      onSuccess: () => {
        closeModal()
      },
      onError: (e) => getErrorsValues(e)
    })
  } else {
    form._method = 'PUT'
    form.post(route('post.update', post), {
      onSuccess: () => {
        closeModal()
      },
      onError: (e) => getErrorsValues(e)
    })
  }
}

const isImage = (type) => {
  return type.toLowerCase().includes('image')
}

const removeFile = (attach) => {
  if(attach.file){
    attachmentFiles.value = attachmentFiles.value.filter(f => f !== attach)
  } else{
    form.deleted_file_ids.push(attach.id)
    attach.deleted = true
  }
}

const removeFromDeleted = (file) => {
  file.deleted = false
  form.deleted_file_ids = form.deleted_file_ids.filter(f=> f !== file.id)
}

const onAttachmentChoose = async (e) => {
  const files = e.target.files

  for(const file of files){
    const myFile = {
      file,
      name: file.name,
      mime: file.type,
      size: file.size,
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

const closeModal = () => {
  form.reset()
  emit('closeModal')
  postAttachments.forEach(f => f.deleted = false)
}

</script>

<template>
  <Modal :show="isModalOpen" @close="closeModal">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
        {{ !!post ? 'Update Post' : 'Create Post' }}
      </h2>
      <div class="mt-6">
        <ckeditor :editor="editor" v-model="form.body" :config="editorConfig"></ckeditor>
      </div>

      <div v-if="postErrors.length" class="border-l-4 border-amber-500 py-2 px-3 bg-amber-100 mt-3 text-gray-800">
        Files must be one of the following extensions:
        {{attachmentsExtensions.join(', ')}}
      </div>

      <div v-if="errors.attachments" class="border-l-4 border-red-500 py-2 px-3 bg-red-100 mt-3 text-gray-800">
        {{errors.attachments}}
      </div>

      <AttachmentItems
          :attachment-files="computedAttachments"
          @remove-file="removeFile"
          @remove-from-deleted="removeFromDeleted"
          :post-errors="postErrors"
      />

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
            Submit
          </PrimaryButton>
        </div>
      </div>
    </div>
  </Modal>
</template>

<style scoped>

</style>
