<template>
  <PageSection title="Your links">
    <LinksToolbar
      v-model="searchInput"
      @update:model-value="searchLink"
    />

    <div class="mt-4">
      <LinkListSkeleton
        v-if="status === 'loading'"
        label="Loading your links..."
      />

      <EmptyState
        v-else-if="status === 'error'"
        tone="error"
        title="Your links could not be loaded"
        description="Check your connection and try again."
      >
        <template #actions>
          <button
            type="button"
            class="btn-quiet"
            @click="load"
          >
            Try again
          </button>
        </template>
      </EmptyState>

      <EmptyState
        v-else-if="links.length === 0 && link_search"
        :title="`No links match &quot;${link_search}&quot;`"
        description="Search looks at link titles and short codes."
      />

      <EmptyState
        v-else-if="links.length === 0"
        title="No links yet"
        description="Links you shorten while signed in show up here."
      >
        <template #actions>
          <router-link
            :to="{ name: 'link.create' }"
            class="btn-primary"
          >
            Shorten your first link
          </router-link>
        </template>
      </EmptyState>

      <template v-else>
        <LinkTable
          :links="links"
          @delete="deleteLink"
        />

        <SurfaceCard class="md:hidden">
          <ul class="divide-y divide-line px-4">
            <LinkCard
              v-for="link in links"
              :key="link.code"
              :link="link"
              @delete="deleteLink"
            />
          </ul>
        </SurfaceCard>
      </template>
    </div>

    <LinkListSkeleton
      v-if="loadingMore"
      class="mt-4"
      :rows="2"
      label="Loading more links..."
    />

    <div
      ref="infiniteScrollTrigger"
      class="h-4"
    />

    <Modal
      ref="modal"
      title="Delete this link?"
      description="The short link stops working right away. This cannot be undone."
      accept-text="Delete link"
      busy-text="Deleting..."
      :busy="deleting"
      accept-class="btn bg-danger text-white hover:bg-danger/90"
      @accept="acceptDelete"
    >
      <dl
        v-if="delete_temp"
        class="space-y-3 text-sm"
      >
        <div>
          <dt class="text-muted">
            Title
          </dt>
          <dd class="mt-0.5 break-words text-ink">
            {{ delete_temp.title }}
          </dd>
        </div>
        <div>
          <dt class="text-muted">
            Short link
          </dt>
          <dd class="mt-0.5 break-all font-mono text-ink">
            {{ delete_temp.short_link.replace(/^https?:\/\//, '') }}
          </dd>
        </div>
        <div>
          <dt class="text-muted">
            Destination
          </dt>
          <dd class="mt-0.5 break-all text-ink">
            {{ delete_temp.link }}
          </dd>
        </div>
      </dl>
    </Modal>
  </PageSection>
</template>

<script>
import { mapState } from 'vuex'
import EmptyState from '../components/EmptyState.vue'
import LinkCard from '../components/LinkCard.vue'
import LinkTable from '../components/LinkTable.vue'
import LinksToolbar from '../components/LinksToolbar.vue'
import LinkListSkeleton from '../components/LinkListSkeleton.vue'
import Modal from '../components/Modal.vue'
import PageSection from '../components/PageSection.vue'
import SurfaceCard from '../components/SurfaceCard.vue'

export default {
  name: 'LinkIndex',

  components: {
    EmptyState,
    LinkCard,
    LinkTable,
    LinkListSkeleton,
    LinksToolbar,
    Modal,
    PageSection,
    SurfaceCard
  },

  data () {
    return {
      status: 'loading',
      searchInput: '',
      waiting: undefined,
      delete_temp: undefined,
      deleting: false,
      loadingMore: false,
      observer: null
    }
  },

  computed: {
    ...mapState(['links', 'link_search', 'next_page', 'page'])
  },

  created () {
    this.searchInput = this.link_search || ''
    this.load()
  },

  mounted () {
    this.observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && this.status === 'ready') {
        this.loadMore()
      }
    }, { rootMargin: '100px', threshold: 0.1 })

    this.observer.observe(this.$refs.infiniteScrollTrigger)
  },

  beforeUnmount () {
    clearTimeout(this.waiting)
    this.observer.disconnect()
  },

  methods: {
    async load () {
      this.status = 'loading'
      this.$store.commit('setPage', 1)

      try {
        await this.$store.dispatch('getLinks')
        this.status = 'ready'
      } catch (e) {
        this.status = 'error'
      }
    },

    searchLink (value) {
      this.searchInput = value
      clearTimeout(this.waiting)

      this.waiting = setTimeout(() => {
        this.$store.commit('setSearch', this.searchInput)
        this.load()
      }, 500)
    },

    deleteLink (code) {
      const link = this.links.find((v) => v.code === code)
      if (!link) {
        return
      }

      this.delete_temp = link
      this.$refs.modal.openModal()
    },

    async acceptDelete () {
      if (!this.delete_temp || this.deleting) {
        return
      }

      this.deleting = true

      try {
        await this.$http.delete(`/link/${this.delete_temp.code}`)
        this.$store.dispatch('removeLink', this.delete_temp.code)
        this.$refs.modal.cancel()
      } catch (e) {
        // the axios interceptor already shows the error
      } finally {
        this.deleting = false
      }
    },

    async loadMore () {
      if (this.loadingMore || !this.next_page) {
        return
      }

      this.loadingMore = true

      try {
        this.$store.commit('setPage', this.page + 1)
        await this.$store.dispatch('getLinks', true)
      } catch (e) {
        this.$store.commit('setPage', this.page - 1)
      } finally {
        this.loadingMore = false
      }
    }
  }
}
</script>
