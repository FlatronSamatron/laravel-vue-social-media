<script setup>
    import {ref} from "vue";

    const {post} = defineProps({
        post: Object
    })
    const {user: {id, avatar_path, name}, attachments, group, body, created_at} = post

    console.log(post)

    const isOpenRef = ref(false);
    const isLong = body.length > 100

    const bodyWidthText = () => {
      return !isOpenRef.value && isLong ? body.slice(0, 100) + '...' : body
    }

    const bodyRef = ref(bodyWidthText())

    const toggle = () => {
      isOpenRef.value = !isOpenRef.value
      bodyRef.value = bodyWidthText()
    }

    const isImage = (attachment) =>{
      return attachment.mime.toLowerCase().includes('image')
    }
</script>

<template>
  <div class="mb-5 bg-white border rounded p-4 shadow mb-3">
    <div class="flex items-center gap-2 mb-2">
      <a href="#">
        <img :src="avatar_path" alt="image" class="w-[45px] rounded-full transition-all hover:scale-110">
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
        <small class="text-gray-400">{{created_at}}</small>
      </div>
    </div>
    <div v-html="bodyRef"></div>
    <small v-if="isLong" @click="toggle" class="text-blue-500 cursor-pointer transition-all hover:underline">
      {{ isOpenRef ? 'Read less' : 'Read more' }}
    </small>

    <div class="grid grid-cols-2 gap-3 mt-3 lg:grid-cols-3 mb-3">
      <div v-for="attachment of attachments" class="relative group">
        <div class="opacity-0 group-hover:opacity-100 transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
               class="size-8 absolute top-2 right-2 bg-gray-600 rounded text-gray-100 cursor-pointer p-2 hover:bg-gray-800 transition-all">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
          </svg>
        </div>

        <img class="object-cover aspect-square" v-if="isImage(attachment)" :src="attachment.url" alt="">
        <div class="aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500" v-else>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
          </svg>

          {{attachment.name}}
        </div>
      </div>
    </div>

    <div class="flex gap-2 text-gray-800">
      <button class="flex gap-1 flex-1 items-center justify-center bg-gray-100 hover:bg-gray-200 transition-all rounded-lg py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
        </svg>
        Like
      </button>
      <button class="flex gap-1 flex-1 items-center justify-center bg-gray-100 hover:bg-gray-200 transition-all rounded-lg py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>

        Comment
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
