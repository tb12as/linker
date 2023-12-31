<template>
  <div class="text-center h-screen flex justify-center items-center">
    <div>
      <h1 class="text-white text-6xl font-bold mb-4">404 | Not Found</h1>
      <p class="text-gray-300 text-2xl mb-8">This page does not exist, just like your crush.</p>

      <router-link
        :to="{ path: '/' }"
        class="bg-blue-700 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded"
      >Go Home</router-link>
    </div>
  </div>
</template>
