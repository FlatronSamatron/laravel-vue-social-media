<script setup type="jsx">
  import {usePage} from "@inertiajs/vue3";
  import {computed, ref} from "vue";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import Edit from "@/Pages/Profile/Edit.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";

  const authUser = usePage().props.auth.user

  const props = defineProps({
    user: {
      type: Object
    }
  })

  const activeTab = ref(0)

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
</script>

<template>
  <AuthenticatedLayout>
    <div class="container mx-auto">
      <div class="relative bg-white">
        <img class="w-full h-[200px] object-cover" src="https://www.prodraw.net/fb_cover/images/fb_cover_65.jpg" alt="">

        <div class="flex">
          <img class="ml-[45px] w-[130px] h-[130px] -mt-[64px]"
               src="https://cdn.iconscout.com/icon/free/png-256/free-avatar-370-456322.png?f=webp" alt="">
          <div class="p-4 flex flex-1 items-center justify-between">
            <h2 class="font-bold text-lg">
              {{user.name}}
            </h2>
            <PrimaryButton v-if="isAuthUser">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
              </svg>
              Edit Profile
            </PrimaryButton>
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