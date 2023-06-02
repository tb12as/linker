<template>
  <section class="lg:m-20 m-5 dark:bg-gray-900">
    <div class="relative overflow-x-auto">
      <div class="pb-4 bg-white dark:bg-gray-900 px-3 py-1">
        <h1
          class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white my-4"
        >Your links</h1>

        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg
              class="w-5 h-5 text-gray-500 dark:text-gray-400"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
          <input
            type="text"
            id="table-search"
            class="outline-none block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search"
          />
        </div>
      </div>
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">Title</th>
            <th scope="col" class="px-6 py-3">Redirect Link</th>
            <th scope="col" class="px-6 py-3">Original Link</th>
            <th scope="col" class="px-6 py-3">Expired at</th>
            <th scope="col" class="px-6 py-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-if="links.length == 0"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <td class="px-6 py-4 text-center" colspan="5">Nothing to show</td>
          </tr>

          <tr
            v-else
            v-for="(v, i) in links"
            :key="i"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <th
              scope="row"
              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ v.title }}
              <span
                class="font-normal bg-blue-500 rounded text-xs text-white px-2 py-1 mx-2 dark:bg-blue-700"
                v-if="v.is_private"
              >(Private)</span>
            </th>
            <td class="px-6 py-4">
              <a :href="v.short_link" target="blank" class="underline">{{ v.short_link }}</a>
            </td>
            <td class="px-6 py-4">{{ v.link }}</td>
            <td class="px-6 py-4">{{ v.expire_at }}</td>
            <td class="px-6 py-4">
              <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    links() {
      // return []
      return this.$store.state.links;
    },
  },
  beforeCreate() {
    this.$store.dispatch("getLinks");
  },
};
</script>
