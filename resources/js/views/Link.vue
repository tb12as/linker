<template>
  <section class="lg:m-20 m-5 dark:bg-gray-900">
    <div class="relative overflow-x-auto">
      <div class="pb-4 bg-white dark:bg-gray-900 py-1">
        <h1
          class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-gray-200 my-4 uppercase"
        >Your links</h1>

        <div class="flex items-center">
          <div>
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
                v-model="search"
                @input="searchLink"
                class="outline-none block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search"
              />
            </div>
          </div>

          <router-link
            :to="{name: 'link.create'}"
            class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800 mt-1 mx-2"
          >Create</router-link>

          <router-link
            :to="{name: 'setting'}"
            class="text-white ml-auto bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-primary-800 mt-1 mx-2"
          >Setting</router-link>
        </div>
      </div>

      <!-- Table -->
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 scrollbar">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Title</th>
            <th scope="col" class="px-6 py-3">Redirect Link</th>
            <!-- <th scope="col" class="px-6 py-3">Original Link</th> -->
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
            <td class="px-6 py-4">{{ i+1 }}</td>
            <th
              scope="row"
              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white flex"
            >
              {{ v.title }}
              <div v-if="v.is_private" class="mx-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="-0.6 -0.6 241.2 241.2"
                  width="20"
                  height="20"
                >
                  <g opacity=".8" fill="#f1f1f1">
                    <path
                      d="M121 0C53.9-.6-.6 53.9 0 121c.6 65.2 53.8 118.4 119 119 67.1.6 121.6-53.9 121-121C239.4 53.8 186.2.6 121 0zM90.5 59c.3-.9 1-1.5 2.2-1.2 2.2.5 19.9 4.3 19.9 4.3s36.8-5.6 38.1-5.9c1.1-.2 1.9.4 2.1 1.4.1.4 6.3 21.3 11.7 39.5H78.3C83.9 79.6 90.1 60 90.5 59zm85.9 103.3c-.8 12.2-10.7 22.1-22.9 22.9-14.3.9-26.1-10.4-26.1-24.5 0-.7 0-1.4.1-2.1-2-.7-4.2-1-6.4-1-2.3 0-4.5.4-6.7 1.1.1.7.1 1.3.1 2 0 14.1-11.8 25.4-26.1 24.5-12.2-.8-22.1-10.7-22.9-22.9-.8-14.2 10.5-26.1 24.5-26.1 10.2 0 19 6.3 22.7 15.2 2.7-.8 5.5-1.3 8.4-1.3 2.8 0 5.5.4 8.1 1.2 3.7-8.9 12.4-15.1 22.7-15.1 14.1 0 25.4 11.9 24.5 26.1zm23.4-34.3H42.4c-.2 0-.3-.3-.1-.4 5.2-2.7 35.4-17.6 79-17.6 43.7 0 73.5 14.8 78.6 17.6.2.1.1.4-.1.4z"
                    />
                    <circle cx="151.9" cy="160.8" r="17.4" />
                    <circle cx="90.1" cy="160.8" r="17.4" />
                  </g>
                </svg>
              </div>
            </th>
            <td class="px-6 py-4">
              <a :href="v.short_link" target="blank" class="underline">{{ v.short_link }}</a>
              <p class="text-xs opacity-50 block mt-1">{{ v.link }}</p>
            </td>
            <!-- <td class="px-6 py-4">{{ v.link }}</td> -->
            <td class="px-6 py-4">{{ v.expire_at }}</td>
            <td class="px-6 py-4">
              <router-link
                :to="{ name: 'link.edit', params: { id: v.code }}"
                class="m-1 font-medium text-blue-600 dark:text-blue-500 hover:underline"
              >Edit</router-link>

              <button
                class="m-1 font-medium text-red-600 dark:text-red-500 hover:underline"
                @click.prevent="deleteLink(v.code)"
              >Delete</button>
            </td>
          </tr>

          <tr
            v-if="next_page"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <td class="px-6 py-4 text-center" colspan="5">
              <button
                @click.prevent="loadMore()"
                class="m-1 font-medium text-white-600 dark:text-white-500 hover:underline"
              >Load More</button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- End of table -->
    </div>

    <Modal
      title="Delete this link?"
      :acceptText="'Delete'"
      :accept-class="'bg-red-700 text-white rounded hover:bg-red-600'"
      ref="modal"
      @accept="acceptDelete()"
    >
      <table v-if="delete_temp" border="1" class="m-0">
        <tr>
          <td class="py-2 pr-1 text-sm text-gray-300 font-semibold" valign="top">Title</td>
          <td class="py-2 pr-1 text-sm text-gray-400" valign="top">:</td>
          <td class="py-2 pr-1 text-sm text-gray-400" valign="top">{{ delete_temp.title }}</td>
        </tr>
        <tr>
          <td class="py-2 pr-1 text-sm text-gray-300 font-semibold" valign="top">Original Link</td>
          <td class="py-2 pr-1 text-sm text-gray-400" valign="top">:</td>
          <td class="py-2 pr-1 text-sm text-gray-400" valign="top">{{ delete_temp.link }}</td>
        </tr>
        <tr>
          <td class="py-2 pr-1 text-sm text-gray-300 font-semibold" valign="top">Redirect Link</td>
          <td class="py-2 pr-1 text-sm text-gray-400" valign="top">:</td>
          <td class="py-2 pr-1 text-sm text-gray-400" valign="top">
            <a
              :href="delete_temp.short_link"
              target="blank"
              class="underline"
            >{{ delete_temp.short_link }}</a>
          </td>
        </tr>
      </table>
    </Modal>
  </section>
</template>

<script>
import Modal from "../components/Modal.vue";
import { mapState } from "vuex";

export default {
  components: {
    Modal,
  },

  data() {
    return {
      search: undefined,
      waiting: undefined,
      delete_temp: undefined,
    };
  },

  computed: {
    ...mapState(["links", "link_search", "next_page", "page"]),
  },

  mounted() {
    if (this.link_search) {
      this.search = this.link_search;
    }
  },

  methods: {
    searchLink() {
      clearTimeout(this.waiting);

      this.waiting = setTimeout(() => {
        this.$store.commit("setSearch", this.search);
        this.$store.commit("setPage", 1);
        this.$store.commit("setLinks", []);
        this.$store.dispatch("getLinks");
      }, 700);
    },

    deleteLink(id) {
      const link = this.links.find((v) => v.code === id);
      if (link) {
        this.delete_temp = link;

        this.$refs.modal.openModal();
      }
    },
    acceptDelete() {
      if (this.delete_temp) {
        this.$http.delete("/link/" + this.delete_temp.code).then(() => {
          this.$store.dispatch("removeLink", this.delete_temp.code);
          this.$refs.modal.cancel();
        });
      }
    },

    loadMore() {
      this.$store.commit("setPage", this.page + 1);
      this.$store.dispatch("getLinks", true);
    },
  },

  beforeCreate() {
    this.$store.commit("setPage", 1);
    this.$store.dispatch("getLinks");
  },
};
</script>
