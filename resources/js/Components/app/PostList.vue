<script setup>
import PostItem from "@/Components/app/PostItem.vue";

const post1 = {
  user: {
    id: 1,
    avatar: `https://randomuser.me/api/portraits/men/${Math.floor(Math.random() * 100)}.jpg`,
    name: 'Oleg Kapsula'
  },
  group: null,
  attachments: [
    {
      id: 1,
      name: 'test.png',
      mime: 'image/png',
      url: 'https://picsum.photos/1000'
    },
    {
      id: 2,
      name: 'test2.png',
      mime: 'image/png',
      url: 'https://picsum.photos/1000'
    },
    {
      id: 2,
      name: 'myDoc.docx',
      mime: 'application/msword',
      url: '#'
    }
  ],
  body: `<p>Lorem ipsum dolor sit</p>`,
  createAt: '2023-11-19 15:12'
}

const post2 = {
  user: {
    id: 2,
    avatar: `https://randomuser.me/api/portraits/men/${Math.floor(Math.random() * 100)}.jpg`,
    name: 'Larisa Tomato'
  },
  group: 'Laravel',
  attachments: [
    {
      id: 1,
      name: 'test.png',
      mime: 'image/png',
      url: 'https://picsum.photos/1000'
    },
    {
      id: 2,
      name: 'test2.png',
      mime: 'image/png',
      url: 'https://picsum.photos/1000'
    }
  ],
  body: `<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab doloribus eaque facilis harum, molestiae non obcaecati ratione! Accusantium consectetur, cupiditate enim illo minus molestias nemo nihil, numquam possimus quasi, quisquam!</p>`,
  createAt: '2023-12-14 12:15'
}
</script>

<template>
  <div class="max-h-[calc(100vh-180px)] overflow-y-auto">
    <PostItem :post="post1"/>
    <PostItem :post="post2"/>
  </div>
</template>

<style
    scoped>

</style>
