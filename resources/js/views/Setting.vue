<template>
  <PageSection
    title="Settings"
    section-class="py-3 md:py-6"
  >
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
      <SurfaceCard
        v-for="setting in settings"
        :key="setting.id"
        class="p-4"
      >
        <div class="flex h-full flex-col">
          <div>
            <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-app-muted">
              {{ setting.type }}
            </p>
            <h2 class="mt-1 text-base font-semibold text-app-text">
              {{ setting.t_name || setting.name }}
            </h2>
            <p class="mt-2 text-sm text-app-muted">
              Current: {{ setting.user_setting ? setting.user_setting.value : '-' }}
            </p>
          </div>

          <div class="mt-4 flex flex-1 flex-col gap-3">
            <input
              v-model="setting.user_value"
              type="text"
              :placeholder="setting.type[0].toUpperCase() + setting.type.slice(1) + ' value'"
              class="app-input"
            >
            <button
              type="button"
              class="mt-auto inline-flex items-center justify-center rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
              @click="saveSetting(setting)"
            >
              Save
            </button>
          </div>
        </div>
      </SurfaceCard>
    </div>

    <EmptyState
      v-if="settings.length === 0"
      title="No settings"
      description=""
      class="mt-6"
    />
  </PageSection>
</template>

<script>
import EmptyState from '../components/EmptyState.vue'
import PageSection from '../components/PageSection.vue'
import SurfaceCard from '../components/SurfaceCard.vue'

export default {
  name: 'SettingPage',

  components: {
    EmptyState,
    PageSection,
    SurfaceCard
  },

  data () {
    return {
      settings: []
    }
  },

  beforeMount () {
    this.loadSettings()
  },

  methods: {
    loadSettings () {
      this.$http.get('/setting').then((r) => {
        this.settings = r.data
      })
    },

    saveSetting (setting) {
      const data = {
        setting_id: setting.id,
        value: setting.user_value
      }
      this.$http.post('/setting', data).then(() => {
        this.loadSettings()
      })
    }
  }
}
</script>
