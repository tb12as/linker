<template>
  <PageSection
    title="Shorten a link"
    description="Paste a long URL and get a short one you can share. No account needed."
  >
    <form
      class="max-w-2xl"
      @submit.prevent="sendForm"
    >
      <label
        for="link"
        class="app-label"
      >Long URL</label>
      <div class="flex flex-col gap-2 sm:flex-row">
        <input
          id="link"
          v-model="form.link"
          type="url"
          name="link"
          class="app-input"
          autocomplete="url"
          placeholder="https://example.com/a/very/long/path"
          required
        >
        <button
          type="submit"
          class="btn-primary sm:w-32"
          :disabled="loading || !form.link"
        >
          {{ loading ? "Shortening..." : "Shorten" }}
        </button>
      </div>

      <div
        v-if="short"
        class="mt-6 rounded-panel border border-line bg-panel p-4"
      >
        <p class="text-sm text-muted">
          Your short link
        </p>
        <ShortLink
          class="mt-1"
          :href="short"
        />
      </div>

      <p class="mt-6 text-sm text-muted">
        Want custom codes and a list of your links?
        <router-link
          :to="{ name: 'login' }"
          class="font-medium text-ink underline underline-offset-4"
        >
          Sign in
        </router-link>
      </p>
    </form>
  </PageSection>
</template>

<script>
import PageSection from '../components/PageSection.vue'
import ShortLink from '../components/ShortLink.vue'

export default {
  name: 'PublicLinkPage',

  components: {
    PageSection,
    ShortLink
  },

  data () {
    return {
      loading: false,
      short: '',
      form: {
        link: ''
      }
    }
  },

  methods: {
    async getIp () {
      // ipify can be blocked by the browser, the title just falls back
      try {
        const res = await fetch('https://api.ipify.org?format=json')
        const json = await res.json()
        return json.ip || null
      } catch (e) {
        return null
      }
    },

    async sendForm () {
      if (!this.form.link || this.loading) {
        return
      }

      this.loading = true
      this.short = ''

      const ip = await this.getIp()
      const body = {
        link: this.form.link,
        title: `Anonymous Link - ${ip || 'Unknown IP'}`
      }

      try {
        const res = await this.$http.post('/link/create', body, {
          headers: { Authorization: '' }
        })
        this.short = (res.data.data && res.data.data.short_link) || ''
      } catch (e) {
        // the axios interceptor already shows the error
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
