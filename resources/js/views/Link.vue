<template>
  <section class="lg:m-20 m-5 dark:bg-gray-900">
    <div class="relative overflow-x-auto">
      <div class="pb-4 bg-white dark:bg-gray-900 py-1">
        <h1
          class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-gray-200 my-4 uppercase"
        >
          Your links
        </h1>

        <div class="flex flex-wrap gap-2">
          <div class="md:w-80 w-full">
            <label
              for="table-search"
              class="sr-only"
            >Search</label>
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
                id="table-search"
                v-model="search"
                type="text"
                class="outline-none block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search"
                @input="searchLink"
              >
            </div>
          </div>

          <router-link
            :to="{name: 'link.create'}"
            class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800 mt-1"
          >
            Create
          </router-link>

          <router-link
            :to="{name: 'setting'}"
            class="text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-primary-800 mt-1"
          >
            Setting
          </router-link>
        </div>
      </div>

      <!-- Cards Grid -->
      <div v-if="links.length === 0 && !loading" class="text-center py-16">
        <div class="text-gray-500 dark:text-gray-400 text-lg">
          Nothing to show
        </div>
      </div>

      <div 
        v-else 
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6"
      >
        <div
          v-for="(link, index) in links"
          :key="link.code"
          class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-200"
        >
          <!-- Card Header -->
          <div class="p-6 pb-4">
            <div class="flex items-start justify-between mb-3">
              <div class="flex items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mr-2">
                  {{ link.title }}
                </h3>
                <div
                  v-if="link.is_private"
                  class="flex-shrink-0"
                  title="Private Link"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="-0.6 -0.6 241.2 241.2"
                    width="20"
                    height="20"
                  >
                    <g
                      opacity=".8"
                      fill="#f1f1f1"
                    >
                      <path
                        d="M121 0C53.9-.6-.6 53.9 0 121c.6 65.2 53.8 118.4 119 119 67.1.6 121.6-53.9 121-121C239.4 53.8 186.2.6 121 0zM90.5 59c.3-.9 1-1.5 2.2-1.2 2.2.5 19.9 4.3 19.9 4.3s36.8-5.6 38.1-5.9c1.1-.2 1.9.4 2.1 1.4.1.4 6.3 21.3 11.7 39.5H78.3C83.9 79.6 90.1 60 90.5 59zm85.9 103.3c-.8 12.2-10.7 22.1-22.9 22.9-14.3.9-26.1-10.4-26.1-24.5 0-.7 0-1.4.1-2.1-2-.7-4.2-1-6.4-1-2.3 0-4.5.4-6.7 1.1.1.7.1 1.3.1 2 0 14.1-11.8 25.4-26.1 24.5-12.2-.8-22.1-10.7-22.9-22.9-.8-14.2 10.5-26.1 24.5-26.1 10.2 0 19 6.3 22.7 15.2 2.7-.8 5.5-1.3 8.4-1.3 2.8 0 5.5.4 8.1 1.2 3.7-8.9 12.4-15.1 22.7-15.1 14.1 0 25.4 11.9 24.5 26.1zm23.4-34.3H42.4c-.2 0-.3-.3-.1-.4 5.2-2.7 35.4-17.6 79-17.6 43.7 0 73.5 14.8 78.6 17.6.2.1.1.4-.1.4z"
                      />
                      <circle
                        cx="151.9"
                        cy="160.8"
                        r="17.4"
                      />
                      <circle
                        cx="90.1"
                        cy="160.8"
                        r="17.4"
                      />
                    </g>
                  </svg>
                </div>
              </div>
              <span class="text-sm text-gray-500 dark:text-gray-400">
                #{{ index + 1 }}
              </span>
            </div>

            <!-- Short Link -->
            <div class="mb-3">
              <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                Short Link
              </label>
              <a
                :href="link.short_link"
                target="_blank"
                class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium break-all"
              >
                {{ link.short_link }}
              </a>
            </div>

            <!-- Original Link -->
            <div class="mb-3">
              <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                Original Link
              </label>
              <p class="text-sm text-gray-600 dark:text-gray-300 break-all line-clamp-2">
                {{ link.link }}
              </p>
            </div>

            <!-- Expire Date -->
            <div class="mb-4">
              <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                Expires At
              </label>
              <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ link.expire_at }}
              </p>
            </div>
          </div>

          <!-- Card Footer -->
          <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 rounded-b-lg border-t border-gray-200 dark:border-gray-600">
            <div class="flex space-x-2">
              <router-link
                :to="{ name: 'link.edit', params: { id: link.code }}"
                class="flex-1 text-center px-3 py-1.5 bg-gray-600 text-white text-xs font-medium rounded hover:bg-gray-700 dark:bg-gray-500 dark:hover:bg-gray-600 transition-colors duration-200"
              >
                Edit
              </router-link>
              <button
                class="flex-1 px-3 py-1.5 bg-gray-700 text-white text-xs font-medium rounded hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-700 transition-colors duration-200"
                @click.prevent="deleteLink(link.code)"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading indicator -->
      <div 
        v-if="loading" 
        class="text-center py-8"
      >
        <div class="inline-flex items-center">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="text-gray-600 dark:text-gray-400">Loading more links...</span>
        </div>
      </div>

      <!-- Infinite scroll trigger -->
      <div 
        ref="infiniteScrollTrigger" 
        class="h-4"
      ></div>
      <!-- End of cards -->
    </div>

    <Modal
      ref="modal"
      title="Delete this link?"
      :accept-text="'Delete'"
      :accept-class="'bg-red-700 text-white rounded hover:bg-red-600'"
      @accept="acceptDelete()"
    >
      <table
        v-if="delete_temp"
        border="1"
        class="m-0"
      >
        <tr>
          <td
            class="py-2 pr-1 text-sm text-gray-300 font-semibold"
            valign="top"
          >
            Title
          </td>
          <td
            class="py-2 pr-1 text-sm text-gray-400"
            valign="top"
          >
            :
          </td>
          <td
            class="py-2 pr-1 text-sm text-gray-400"
            valign="top"
          >
            {{ delete_temp.title }}
          </td>
        </tr>
        <tr>
          <td
            class="py-2 pr-1 text-sm text-gray-300 font-semibold"
            valign="top"
          >
            Original Link
          </td>
          <td
            class="py-2 pr-1 text-sm text-gray-400"
            valign="top"
          >
            :
          </td>
          <td
            class="py-2 pr-1 text-sm text-gray-400"
            valign="top"
          >
            {{ delete_temp.link }}
          </td>
        </tr>
        <tr>
          <td
            class="py-2 pr-1 text-sm text-gray-300 font-semibold"
            valign="top"
          >
            Redirect Link
          </td>
          <td
            class="py-2 pr-1 text-sm text-gray-400"
            valign="top"
          >
            :
          </td>
          <td
            class="py-2 pr-1 text-sm text-gray-400"
            valign="top"
          >
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
import { mapState } from 'vuex'
import Modal from '../components/Modal.vue'

export default {
  name: 'LinkIndex',

  components: {
    Modal
  },

  data () {
    return {
      search: undefined,
      waiting: undefined,
      delete_temp: undefined,
      loading: false,
      observer: null
    }
  },

  computed: {
    ...mapState(['links', 'link_search', 'next_page', 'page'])
  },

  mounted () {
    if (this.link_search) {
      this.search = this.link_search
    }
    this.setupInfiniteScroll()
  },

  beforeUnmount () {
    if (this.observer) {
      this.observer.disconnect()
    }
  },

  beforeCreate () {
    this.$store.commit('setPage', 1)
    this.$store.dispatch('getLinks')
  },

  methods: {
    setupInfiniteScroll () {
      if (!this.$refs.infiniteScrollTrigger) {
        this.$nextTick(() => {
          this.setupInfiniteScroll()
        })
        return
      }

      this.observer = new IntersectionObserver(
        (entries) => {
          const target = entries[0]
          if (target.isIntersecting && this.next_page && !this.loading) {
            this.loadMore()
          }
        },
        {
          root: null,
          rootMargin: '100px',
          threshold: 0.1
        }
      )

      this.observer.observe(this.$refs.infiniteScrollTrigger)
    },

    searchLink () {
      clearTimeout(this.waiting)

      this.waiting = setTimeout(() => {
        this.$store.commit('setSearch', this.search)
        this.$store.commit('setPage', 1)
        this.$store.commit('setLinks', [])
        this.$store.dispatch('getLinks')
        
        // Reset infinite scroll after search
        this.$nextTick(() => {
          if (this.observer) {
            this.observer.disconnect()
          }
          this.setupInfiniteScroll()
        })
      }, 700)
    },

    deleteLink (id) {
      const link = this.links.find((v) => v.code === id)
      if (link) {
        this.delete_temp = link
        this.$refs.modal.openModal()
      }
    },

    acceptDelete () {
      if (this.delete_temp) {
        this.$http.delete(`/link/${this.delete_temp.code}`).then(() => {
          this.$store.dispatch('removeLink', this.delete_temp.code)
          this.$refs.modal.cancel()
        })
      }
    },

    async loadMore () {
      if (this.loading || !this.next_page) {
        return
      }

      this.loading = true
      
      try {
        this.$store.commit('setPage', this.page + 1)
        await this.$store.dispatch('getLinks', true)
      } catch (error) {
        console.error('Error loading more links:', error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media (max-width: 768px) {
  .grid {
    grid-template-columns: 1fr;
  }
}
</style>
