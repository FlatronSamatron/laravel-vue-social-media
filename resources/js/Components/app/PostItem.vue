<script setup>
import {ref} from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import {
  EllipsisHorizontalIcon,
  HandThumbUpIcon,
  ChatBubbleLeftRightIcon,
  ChatBubbleLeftEllipsisIcon
} from '@heroicons/vue/24/outline'
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import {router, usePage} from "@inertiajs/vue3";
import TrimText from "@/Components/app/TrimText.vue";
import PostModal from "@/Components/app/PostModal.vue";
import AttachmentItems from "@/Components/app/AttachmentItems.vue";
import axiosClient from "@/axiosClient.js";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const {post} = defineProps({
  post: Object
})

const {
  user: {id: userId, avatar_path, name},
  attachments,
  group,
  body,
  created_at,
  id: postId,
  num_of_reactions,
  current_user_has_reaction,
  num_of_comments,
  comments
} = post

const isUpdateModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const isCommentsOpen = ref(false)
const newComment = ref('')
const editComment = ref({})

const likeData = ref({
  num_of_reactions,
  current_user_has_reaction
})

const authUser = usePage().props.auth.user

const deletePost = () => {
  router.delete(route('post.destroy', post), {
    onSuccess: () => {
      isDeleteModalOpen.value = false
    }
  })
}

const sendReaction = () => {
  axiosClient.post(route('post.reaction', post), {
    reaction: 'like'
  }).then(({data}) => {
    likeData.value.num_of_reactions = data.num_of_reactions
    likeData.value.current_user_has_reaction = data.current_user_has_reaction
  })
}

const createComment = () => {
  axiosClient.post(route('comment.create', post), {
    comment: newComment.value
  }).then(({data}) => {
    newComment.value = ''
    comments.unshift(data)
  })
}

const deleteComment = (comment) => {
  axiosClient.delete(route('comment.delete', comment.id)).then(({data}) => {
    const commentIndex = comments.findIndex(c => comment.id === c.id)
    comments.splice(commentIndex, 1)
  })
}

const editCommentHandler = () => {
  const {id, comment} = editComment.value
  axiosClient.put(route('comment.update', id), {
    comment: comment
  }).then(({data}) => {
    const commentIndex = comments.findIndex(c => id === c.id)
    comments[commentIndex].comment = data.comment
    editComment.value = {}
  })
}

const sendCommentReaction = (comment) => {
  axiosClient.post(route('comment.reaction', comment.id), {
    reaction: 'like'
  }).then(({data}) => {
    comment.num_of_reactions = data.num_of_reactions
    comment.current_user_has_reaction = data.current_user_has_reaction
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
              <li @click="isUpdateModalOpen=true"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                Update Post
              </li>
              <li @click="isDeleteModalOpen=true"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                Delete Post
              </li>
            </ul>
          </template>
        </Dropdown>

        <PostModal v-if="isUpdateModalOpen" :isModalOpen="isUpdateModalOpen" @closeModal="isUpdateModalOpen=false"
                   :post="post"/>

        <Modal :show="isDeleteModalOpen" @close="isDeleteModalOpen=false">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
              Delete Post
            </h2>

            <div class="mt-2">
              <PostUserHeader class="mb-2" :avatarPath="avatar_path" :name="name" :group="group"
                              :createdAt="created_at"/>
              <div v-html="post.body" class="w-full"/>
            </div>

            <div class="mt-6 flex justify-end">
              <SecondaryButton @click="isDeleteModalOpen=false"> Cancel</SecondaryButton>

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

    <AttachmentItems :attachment-files="post.attachments" :isPost="true"/>

    <div class="flex gap-2 text-gray-800">
      <button
          @click="sendReaction"
          class="flex gap-1 flex-1 items-center justify-center transition-all rounded-lg py-3"
          :class="likeData.current_user_has_reaction ? 'bg-blue-100 hover:bg-blue-200' : 'bg-gray-100 hover:bg-gray-200'"
      >
        <HandThumbUpIcon class="size-6"/>
        <span class="mr-1">
          {{ likeData.num_of_reactions }}
        </span>
        {{ likeData.current_user_has_reaction ? 'Unlike' : 'Like' }}
      </button>
      <button
          class="flex gap-1 flex-1 items-center justify-center bg-gray-100 hover:bg-gray-200 transition-all rounded-lg py-3"
          @click="isCommentsOpen=!isCommentsOpen"
      >
        <ChatBubbleLeftRightIcon class="size-6"/>
        <span class="mr-1">
          {{ comments.length }}
        </span>
        Comment
      </button>
    </div>
    <!--    COMMENTS   -->
    <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
    >
      <div v-if="isCommentsOpen">
        <div class="w-full mt-5">
          <TextArea v-model="newComment" placeholder="Enter your comment here" class="w-full"></TextArea>
          <PrimaryButton @click="createComment" class="w-full flex justify-center items-center">Submit</PrimaryButton>

          <div class="border border-gray-200 rounded-md mt-5">
            <div class="p-3 border-b-2 last:border-b-0" v-for="comment in comments" :key="comment.id">
              <div class="flex justify-between">
                <PostUserHeader :avatarPath="comment.user.avatar_path" :name="comment.user.name" :group="group"
                                :createdAt="comment.created_at"/>
                <Dropdown v-if="userId === authUser.id" align="right" width="48">
                  <template #trigger>
                    <span class="cursor-pointer">
                        <EllipsisHorizontalIcon class="size-7"/>
                    </span>
                  </template>

                  <template #content>
                    <ul class="text-m text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                      <li @click="editComment=comment"
                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                        Update Comment
                      </li>
                      <li @click="deleteComment(comment)"
                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                        Delete Comment
                      </li>
                    </ul>
                  </template>
                </Dropdown>
              </div>

              <div v-if="editComment.id && editComment.id === comment.id" class="mt-2">
                <TextArea v-model="editComment.comment" placeholder="Enter your comment here" class="w-full"></TextArea>
                <div class="flex w-full justify-end">
                  <SecondaryButton @click="editComment={}">Cancel</SecondaryButton>
                  <PrimaryButton class="ml-3" @click="editCommentHandler">Submit</PrimaryButton>
                </div>
              </div>
              <div v-else class="pt-4">
                {{ comment.comment }}
              </div>
              <div class="flex gap-3 mt-2">
                <button
                    @click="sendCommentReaction(comment)"
                    class="flex items-center cursor-pointer text-indigo-500 hover:bg-indigo-100 rounded py-0.5 px-1 border border-indigo-100 transition-all"
                    :class="comment.current_user_has_reaction ? 'bg-indigo-100 hover:bg-indigo-200' : 'bg-transparent'">
                  <HandThumbUpIcon class="size-4"/>
                  <span class="mr-2 ml-1">{{ comment.num_of_reactions }}</span>
                  {{ comment.current_user_has_reaction ? 'Unlike' : 'Like' }}
                </button>
                <button
                    class="flex items-center cursor-pointer text-indigo-500 hover:bg-indigo-100 rounded py-0.5 px-1 border border-indigo-100 transition-all">
                  <ChatBubbleLeftEllipsisIcon class="size-4 mr-2"/>
                  Reply
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>

  </div>
</template>

<style scoped>

</style>
