<template>
  <PageSection
    title="Your links"
    section-class="py-3 md:py-6"
  >
    <LinksToolbar
      v-model="searchInput"
      @update:model-value="searchLink"
    />

    <EmptyState
      v-if="links.length === 0 && !loading"
      class="mt-6"
      title="No links"
      description=""
    >
      <template #actions>
        <router-link
          :to="{ name: 'link.create' }"
          class="inline-flex items-center gap-2 rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
        >
          <Plus class="h-4 w-4" />
          Create
        </router-link>
      </template>
    </EmptyState>

    <div
      v-else
      class="mt-5"
    >
      <LinkTable
        :links="links"
        @delete="deleteLink"
      />

      <div class="grid gap-4 md:hidden">
        <LinkCard
          v-for="(link, index) in links"
          :key="link.code"
          :link="link"
          :index="index"
          @delete="deleteLink"
        />
      </div>
    </div>

    <LoadingState
      v-if="loading"
      label="Loading more links..."
    />

    <div
      ref="infiniteScrollTrigger"
      class="h-4"
    />

    <Modal
      ref="modal"
      title="Delete link?"
      accept-text="Delete"
      accept-class="bg-red-600 text-white hover:bg-red-500"
      @accept="acceptDelete()"
    >
      <div
        v-if="delete_temp"
        class="space-y-3 text-sm"
      >
        <div class="rounded-lg border border-app-border bg-app-muted-panel-soft p-3">
          <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-app-muted">
            Title
          </p>
          <p class="mt-1 text-app-text">
            {{ delete_temp.title }}
          </p>
        </div>

        <div class="rounded-lg border border-app-border bg-app-muted-panel-soft p-3">
          <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-app-muted">
            Target
          </p>
          <p class="mt-1 break-all text-app-text">
            {{ delete_temp.link }}
          </p>
        </div>

        <div class="rounded-lg border border-app-border bg-app-muted-panel-soft p-3">
          <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-app-muted">
            Short
          </p>
          <a
            :href="delete_temp.short_link"
            target="_blank"
            rel="noreferrer"
            class="mt-1 block break-all text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300"
          >
            {{ delete_temp.short_link }}
          </a>
        </div>
      </div>
    </Modal>
  </PageSection>
</template>

<script>
import { Plus } from 'lucide-vue-next'
import { mapState } from 'vuex'
import EmptyState from '../components/EmptyState.vue'
import LinkCard from '../components/LinkCard.vue'
import LinkTable from '../components/LinkTable.vue'
import LinksToolbar from '../components/LinksToolbar.vue'
import LoadingState from '../components/LoadingState.vue'
import Modal from '../components/Modal.vue'
import PageSection from '../components/PageSection.vue'

export default {
  name: 'LinkIndex',

  components: {
    EmptyState,
    LinkCard,
    LinkTable,
    LinksToolbar,
    LoadingState,
    Modal,
    PageSection,
    Plus
  },

  data () {
    return {
      searchInput: '',
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
    this.searchInput = this.link_search || ''
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

    searchLink (value) {
      this.searchInput = value
      clearTimeout(this.waiting)

      this.waiting = setTimeout(() => {
        this.$store.commit('setSearch', this.searchInput)
        this.$store.commit('setPage', 1)
        this.$store.commit('setLinks', [])
        this.$store.dispatch('getLinks')

        this.$nextTick(() => {
          if (this.observer) {
            this.observer.disconnect()
          }
          this.setupInfiniteScroll()
        })
      }, 500)
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
