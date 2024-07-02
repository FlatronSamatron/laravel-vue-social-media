<script setup>
    import {ref} from "vue";
    import Dropdown from "@/Components/Dropdown.vue";
    import { EllipsisHorizontalIcon, HandThumbUpIcon, ChatBubbleLeftRightIcon, ArrowDownTrayIcon, DocumentIcon } from '@heroicons/vue/24/outline'
    import Modal from "@/Components/Modal.vue";
    import DangerButton from "@/Components/DangerButton.vue";
    import SecondaryButton from "@/Components/SecondaryButton.vue";
    import TextArea from "@/Components/TextArea.vue";
    import PostUserHeader from "@/Components/app/PostUserHeader.vue";
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import {router, useForm} from "@inertiajs/vue3";
    import TrimText from "@/Components/app/TrimText.vue";


    const {post} = defineProps({
        post: Object
    })

    const {user: {id, avatar_path, name}, attachments, group, body, created_at} = post

    const updatePostForm = useForm({
      id,
      body
    })

    const isImage = (attachment) =>{
      return attachment.mime.toLowerCase().includes('image')
    }

    const isUpdateModalOpen = ref(false)
    const isDeleteModalOpen = ref(false)

    const submit = () => {
      updatePostForm.put(route('post.update', post), {
        onSuccess: () => {
          isUpdateModalOpen.value = false
        }
      })
    }

    const deletePost = () => {
      router.delete(route('post.destroy', post), {
        onSuccess: () => {
          isDeleteModalOpen.value = false
        }
      })
    }
</script>

<template>
  <div class="mb-5 bg-white border rounded p-4 shadow mb-3">
    <div class="flex items-start mb-2 justify-between">
      <PostUserHeader :avatarPath="avatar_path" :name="name" :group="group" :createdAt="created_at"/>
      <div class="flex">
        <Dropdown align="right" width="48">
          <template #trigger>
              <span class="cursor-pointer">
                  <EllipsisHorizontalIcon class="size-7"/>
              </span>
          </template>

          <template #content>
            <ul class="text-m text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
              <li @click="isUpdateModalOpen=true" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                Update Post
              </li>
              <li @click="isDeleteModalOpen=true" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                Delete Post
              </li>
            </ul>
          </template>
        </Dropdown>

        <Modal :show="isUpdateModalOpen" @close="isUpdateModalOpen=false">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
              Update Post
            </h2>

            <div class="mt-6">
              <TextArea v-model="updatePostForm.body" class="w-full"/>
            </div>

            <div class="mt-6 flex justify-end">
              <SecondaryButton @click="isUpdateModalOpen=false"> Cancel </SecondaryButton>

              <PrimaryButton
                  class="ms-3"
                  @click="submit"
              >
                Update Post
              </PrimaryButton>
            </div>
          </div>
        </Modal>

        <Modal :show="isDeleteModalOpen" @close="isDeleteModalOpen=false">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
              Delete Post
            </h2>

            <div class="mt-2">
              <PostUserHeader class="mb-2" :avatarPath="avatar_path" :name="name" :group="group" :createdAt="created_at"/>
              <div v-html="post.body" class="w-full"/>
            </div>

            <div class="mt-6 flex justify-end">
              <SecondaryButton @click="isDeleteModalOpen=false"> Cancel </SecondaryButton>

              <DangerButton
                  class="ms-3"
                  @click="deletePost"
              >
                Delete Post
              </DangerButton>
            </div>
          </div>
        </Modal>
      </div>
    </div>
    <TrimText :text="post.body"/>

    <div class="grid grid-cols-2 gap-3 mt-3 lg:grid-cols-3 mb-3">
      <div v-for="attachment of attachments" class="relative group">
        <div class="opacity-0 group-hover:opacity-100 transition-all">
          <ArrowDownTrayIcon class="size-8 absolute top-2 right-2 bg-gray-600 rounded text-gray-100 cursor-pointer p-2 hover:bg-gray-800 transition-all"/>
        </div>

        <img class="object-cover aspect-square" v-if="isImage(attachment)" :src="attachment.url" alt="">
        <div class="aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500" v-else>
          <DocumentIcon class="size-16"/>

          {{attachment.name}}
        </div>
      </div>
    </div>

    <div class="flex gap-2 text-gray-800">
      <button class="flex gap-1 flex-1 items-center justify-center bg-gray-100 hover:bg-gray-200 transition-all rounded-lg py-3">
        <HandThumbUpIcon class="size-6"/>
        Like
      </button>
      <button class="flex gap-1 flex-1 items-center justify-center bg-gray-100 hover:bg-gray-200 transition-all rounded-lg py-3">
        <ChatBubbleLeftRightIcon class="size-6"/>
        Comment
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
