<script setup>

import TextInput from "@/Components/TextInput.vue";
import GroupItem from "@/Components/app/GroupItem.vue";
import {ref} from "vue";

const searchKeyWord = ref('');
</script>

<template>
  <div class="bg-white rounded-lg border shadow pt-3">
    <h2 class="text-2xl font-bold px-3 mb-4">My groups</h2>
    <div class="px-3">
      <TextInput model-value="" placeholder="Search" class="w-full"/>
      <div class="py-8">
        <div v-if="false" class="text-gray-400 flex text-center p-3">
          You are not joined to any groups
        </div>
        <div v-else class="max-h-[calc(100vh-260px)] overflow-y-auto">
          <GroupItem
              image="https://picsum.photos/100"
              title="Laravel Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />
          <GroupItem
              image="https://picsum.photos/100"
              title="Laravel Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />
          <GroupItem
              image="https://picsum.photos/100"
              title="Laravel Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />
          <GroupItem
            image="https://picsum.photos/100"
            title="Laravel Developers"
            description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />
          <GroupItem
              image="https://picsum.photos/100"
              title="Laravel Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />
          <GroupItem
              image="https://picsum.photos/100"
              title="Laravel Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />

          <GroupItem
              image="https://picsum.photos/100"
              title="Vue Developers"
              description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
          />




        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
