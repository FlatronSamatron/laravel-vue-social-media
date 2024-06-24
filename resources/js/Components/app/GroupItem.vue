<script setup>
    defineProps({
        image: String,
        title: String,
        description: String
    })
</script>

<template>
    <div class="flex items-start gap-3 mb-3 cursor-pointer hover:bg-gray-100 rounded p-2 transition-all">
        <img :src="image" class="w-[32px] rounded-full" alt="img">
        <div>
            <h3 class="font-bold text-xl">
                {{title}}
            </h3>
            <div class="text-xs text-gray-500">
                {{description}}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
