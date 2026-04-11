<template>
  <PageSection
    :title="pageTitle"
    section-class="py-3 md:py-6"
  >
    <div class="max-w-3xl">
      <SurfaceCard class="p-4 sm:p-5">
        <form
          class="space-y-5"
          @submit.prevent="sendNewLink"
        >
          <div class="grid gap-4">
            <CustomInput
              id="title"
              v-model="form.title"
              label="Title"
              type="text"
              placeholder="e.g. Portfolio drive link"
              :required="true"
              autocomplete="off"
            />

            <CustomInput
              id="link"
              v-model="form.link"
              label="Destination URL"
              type="url"
              placeholder="https://yourlink.com"
              :required="true"
              autocomplete="url"
            />

            <CustomInput
              v-if="userIsPro"
              id="custom"
              v-model="form.custom"
              label="Custom code"
              type="text"
              placeholder="Optional unique code"
            />

            <div class="rounded-lg border border-app-border bg-app-muted-panel-soft p-3">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm font-semibold text-app-text">
                    Private
                  </p>
                  <p class="mt-1 text-sm text-app-muted">
                    Pro only
                  </p>
                </div>

                <label class="relative inline-flex cursor-pointer items-center">
                  <input
                    v-model="form.private"
                    type="checkbox"
                    class="peer sr-only"
                  >
                  <span class="h-7 w-12 rounded-full bg-slate-300 transition peer-checked:bg-cyan-500 dark:bg-slate-700" />
                  <span class="absolute left-1 top-1 h-5 w-5 rounded-full bg-white transition peer-checked:translate-x-5" />
                </label>
              </div>
            </div>
          </div>

          <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <button
              type="submit"
              class="inline-flex items-center justify-center rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50"
              :disabled="loading"
            >
              {{ loading ? 'Saving...' : submitLabel }}
            </button>

            <router-link
              :to="{ name: 'user.link' }"
              class="text-sm text-app-muted hover:text-app-text"
            >
              Back to links
            </router-link>
          </div>
        </form>
      </SurfaceCard>
    </div>
  </PageSection>
</template>

<script>
import { mapState } from 'vuex'
import CustomInput from '../components/CustomInput.vue'
import PageSection from '../components/PageSection.vue'
import SurfaceCard from '../components/SurfaceCard.vue'

export default {
  name: 'LinkForm',

  components: {
    CustomInput,
    PageSection,
    SurfaceCard
  },

  data () {
    return {
      loading: false,
      form: {
        private: false
      }
    }
  },

  computed: {
    ...mapState(['user']),

    userIsPro () {
      return Boolean(this.user && this.user.is_pro)
    },

    isEditing () {
      return Boolean(this.$route.params.id)
    },

    pageTitle () {
      return this.isEditing ? 'Edit link' : 'Create a new link'
    },
    submitLabel () {
      return this.isEditing ? 'Save Changes' : 'Create Link'
    }
  },

  beforeMount () {
    if (this.$route.params.id) {
      this.loadLink(this.$route.params.id)
    }
  },

  created () {
    if (this.userIsPro) {
      this.form.private = true
    }
  },

  methods: {
    loadLink (code) {
      this.$http.get(`/link/get/${code}`).then((res) => {
        this.form = { ...res.data.data }
        if (this.userIsPro) {
          this.form.custom = res.data.data.code
          this.form.private = res.data.data.is_private
        }
      })
    },

    async sendNewLink () {
      if (this.loading) {
        return
      }

      this.loading = true

      if (!this.userIsPro) {
        delete this.form.private
      }

      await this.$http
        .post('/link/create', this.form)
        .then(() => {
          this.$router.push({ name: 'user.link' })
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
