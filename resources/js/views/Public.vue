<template>
  <PageSection
    title="Create short link"
    section-class="py-3 md:py-6"
  >
    <SurfaceCard class="max-w-2xl p-4 sm:p-5">
      <form
        class="space-y-4"
        @submit.prevent="sendForm"
      >
        <CustomInput
          id="link"
          v-model="form.link"
          label="URL"
          type="url"
          name="link"
          :required="true"
          autocomplete="url"
          placeholder="https://a-very-long-link.example"
        />

        <CustomInput
          id="short"
          v-model="form.short"
          label="Short link"
          type="text"
          readonly
          :disabled="form.short === ''"
          placeholder="lnkr.pw/r/[code]"
          @click="form.short === '' ? () => {} : copyToClipboard(form.short)"
        />

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
          <button
            type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50"
            :disabled="loading || !form.link"
          >
            {{ loading ? 'Creating...' : 'Create' }}
          </button>

          <router-link
            to="/login"
            class="text-sm text-app-muted hover:text-app-text"
          >
            Sign in for more options
          </router-link>
        </div>
      </form>
    </SurfaceCard>
  </PageSection>
</template>

<script>
import { notify } from '@kyvg/vue3-notification'
import CustomInput from '../components/CustomInput.vue'
import PageSection from '../components/PageSection.vue'
import SurfaceCard from '../components/SurfaceCard.vue'

export default {
  name: 'PublicLinkPage',

  components: {
    CustomInput,
    PageSection,
    SurfaceCard
  },

  data () {
    return {
      loading: false,
      waiting: undefined,
      form: {
        link: '',
        short: ''
      }
    }
  },

  methods: {
    async copyURL (mytext) {
      try {
        await navigator.clipboard.writeText(mytext)
        notify({
          title: 'Success',
          type: 'success',
          text: 'Copied to clipboard'
        })
      } catch (error) {
        notify({
          title: 'Error',
          type: 'error',
          text: 'Unable to copy the short link'
        })
      }
    },

    copyToClipboard (text) {
      clearTimeout(this.waiting)
      this.waiting = setTimeout(() => {
        this.copyURL(text)
      }, 300)
    },

    async getIp () {
      const data = await fetch('https://api.ipify.org?format=json')
      const json = await data.json()
      return json.ip || null
    },

    async generateTitle () {
      const titles = ['Anonymous Link']
      const ip = await this.getIp()
      titles.push(ip || 'Unknown IP')

      return titles.join(' - ')
    },

    async sendForm () {
      const { link } = this.form
      if (!link || this.loading) {
        return
      }

      this.loading = true
      this.form.title = await this.generateTitle()

      await this.$http
        .post('/link/create', this.form, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': ''
          }
        })
        .then((res) => {
          const link = res.data.data || undefined
          if (!link) {
            return
          }

          this.form.short = link.short_link
          if (this.form.short) {
            this.form.short = this.form.short.replace('https://', '')
            this.form.short = this.form.short.replace('http://', '')
          }
        })
        .finally(() => {
          setTimeout(() => {
            this.loading = false
          }, 600)
        })
    }
  }
}
</script>
