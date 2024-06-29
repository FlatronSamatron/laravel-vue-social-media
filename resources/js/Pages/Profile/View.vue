<script setup type="jsx">
  import {usePage} from "@inertiajs/vue3";
  import {ref} from "vue";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import Edit from "@/Pages/Profile/Edit.vue";
  import { useForm } from '@inertiajs/vue3'

  import { XMarkIcon, CameraIcon, CheckCircleIcon, PhotoIcon } from '@heroicons/vue/24/solid'

  const authUser = usePage().props.auth.user

  const props = defineProps({
    user: Object,
    errors: Object,
    success: String
  })

  const imagesForm = useForm({
    avatar: null,
    cover: null,
  })

  const activeTab = ref(0)
  const coverImageSrc = ref('');
  const avatarImageSrc = ref('');
  const showNotification = ref(false);

  const isAuthUser = authUser && authUser.id === props.user.id

  const tabsList = [
    {
      title: 'About',
      content: 'About'
    },
    {
      title: 'Posts',
      content: 'Posts'
    },
    {
      title: 'Followers',
      content: 'Followers'
    },
    {
      title: 'Followings',
      content: 'Followings'
    },
    {
      title: 'Photos',
      content: 'Photos'
    }
  ]

  const tabs = isAuthUser ? tabsList : tabsList.slice(1)

  const onImgChange = (event, imgType) => {
    imagesForm[imgType] = event.target.files[0]
    const {type} = imagesForm[imgType]

    if(imagesForm[imgType] && type.includes('image')){
      const reader = new FileReader();
      reader.onload = () => {
        if(imgType === 'cover'){
          coverImageSrc.value = reader.result
        } else {
          avatarImageSrc.value = reader.result
        }
      }
      reader.readAsDataURL(imagesForm[imgType])
    }
  }

  const cancelCoverImage = () => {
    imagesForm.cover = null
    coverImageSrc.value = ''
  }

  const cancelAvatarImage = () => {
    imagesForm.avatar = null
    avatarImageSrc.value = ''
  }

  const submitImage = () => {
    //used ziggy for route
    imagesForm.post(route('profile.updateImages'), {
      onSuccess: () => {
        !!coverImageSrc.value.length && cancelCoverImage()
        !!avatarImageSrc.value.length && cancelAvatarImage()
        showNotification.value = true
        setTimeout(()=>{
          showNotification.value = false
        },3000)
      },

      onError: () => {
        showNotification.value = true
        setTimeout(()=>{
          showNotification.value = false
        },3000)
      }
    })
  }

</script>

<template>
  <AuthenticatedLayout>
    <div class="container mx-auto">
<!--      Notifications-->
      <div
          v-show="success && showNotification"
          class="z-1 mt-2 font-bold p-5 text-lg bg-emerald-500 text-white absolute h-5 w-[50%] m-auto left-0 right-0 top-0 bottom-0 flex justify-center items-center rounded"
      >
        {{success}}
      </div>

      <div
          v-show="errors.cover"
          class="z-1 mt-2 font-bold p-5 text-lg bg-red-500 text-white absolute h-5 w-[50%] m-auto left-0 right-0 top-0 bottom-0 flex justify-center items-center rounded"
      >
        {{errors.cover}}
      </div>

      <div class="bg-white">

        <!--Cover-->
        <div class="group/cover relative ">
          <img class="w-full h-[200px] object-cover" :src="coverImageSrc || user.cover_path || '/img/default_cover.jpg'" alt="cover_image">

          <div class="absolute top-2 right-2">
            <button v-if="!coverImageSrc" class="opacity-0 group-hover/cover:opacity-100 bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs flex items-center transition-all rounded overflow-hidden">
              <PhotoIcon class="size-4 mr-1"/>
              <input type="file" class="w-[100%] absolute left-0 top-0 opacity-0 cursor-pointer" @change="(e)=>onImgChange(e, 'cover')"/>
              Update Cover Image
            </button>

            <div class="opacity-0 group-hover/cover:opacity-100 transition-all flex" v-else>
              <button @click="cancelCoverImage" class="bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs flex items-center rounded">
                <XMarkIcon class="size-4 mr-1"/>
                Cancel
              </button>

              <button @click="submitImage" class="bg-gray-800 hover:bg-gray-900 text-gray-100 py-1 px-2 text-xs flex items-center rounded ml-1">
                <CheckCircleIcon class="size-4 mr-1"/>
                Submit
              </button>
            </div>
          </div>
        </div>

        <!--Avatar-->
        <div class="flex">
          <div class="relative group/avatar -mt-[64px] ml-[45px]">
            <img class="w-[130px] h-[130px] rounded-full"
                 :src="avatarImageSrc || user.avatar_path || '/img/default_avatar.webp'" alt="avatar">
            <div class="absolute w-[50%] h-[50%] m-auto left-0 right-0 top-0 bottom-0 flex justify-center items-center">
              <button v-if="!avatarImageSrc" class="opacity-0 group-hover/avatar:opacity-100 bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs flex items-center transition-all rounded overflow-hidden">
                <CameraIcon class="size-4 mr-1"/>
                <input type="file" class="absolute w-[50%] h-[50%] m-auto left-0 right-0 top-0 bottom-0 opacity-0 cursor-pointer" @change="(e)=>onImgChange(e, 'avatar')"/>
              </button>

              <div class="opacity-0 group-hover/avatar:opacity-100 transition-all flex-col" v-else>
                <button @click="cancelAvatarImage" class="bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs flex items-center rounded">
                  <XMarkIcon class="size-4 mr-1"/>
                  Cancel
                </button>

                <button @click="submitImage" class="bg-gray-800 hover:bg-gray-900 text-gray-100 py-1 px-2 text-xs flex items-center rounded mt-1">
                  <CheckCircleIcon class="size-4 mr-1"/>
                  Submit
                </button>
              </div>
            </div>
          </div>

          <div class="p-4 flex flex-1 items-center justify-between">
            <h2 class="font-bold text-lg">
              {{user.name}}
            </h2>
<!--            <PrimaryButton v-if="isAuthUser">-->
<!--              <PencilIcon class="size-4 mr-2"/>-->
<!--              Edit Profile-->
<!--            </PrimaryButton>-->
          </div>
        </div>
      </div>
      <div class="mb-14 w-full border-t">
        <div class="flex bg-white">
          <a
              v-for="(tab, index) in tabs"
              :key="index"
              @click="activeTab = index"
              :class="{
                  'bg-white text-blue-500 border-b-2 border-blue-500': activeTab === index,
                  'text-gray-700':
                    activeTab !== index
                }"
              class="px-3 py-2.5 outline-none cursor-pointer"
          >
            {{ tab.title }}
          </a>
        </div>
        <!-- Display active tab content -->
        <div
            class="mt-3"
        >
          <span v-if="tabs[activeTab].title === 'About'">
            <Edit/>
          </span>
          <span v-else>
            {{ tabs[activeTab].title }}
          </span>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>