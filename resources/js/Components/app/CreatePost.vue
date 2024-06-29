<script setup>
    import {ref} from "vue";
    import TextArea from "@/Components/TextArea.vue";
    import {useForm} from "@inertiajs/vue3";

    const postCreating = ref(false)

    const newPostForm = useForm({
      body: ''
    })

    const submit = () => {
      newPostForm.post(route('post.create'), {
        onSuccess: () => {
          newPostForm.reset()
        }
      })
    }
</script>

<template>
    <div class="bg-white rounded-lg border shadow p-3 mb-3">
      <TextArea @click="postCreating = true" placeholder="Click here to create new post" class="w-full" rows="1" v-model="newPostForm.body"/>
        <div v-if="postCreating" class="flex justify-between mt-3">
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white
             shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
             focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
                Attach Files
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
            </button>
            <button @click="submit" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white
             shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
             focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Submit
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
