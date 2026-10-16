<template>
  <PageSection title="Settings">
    <SettingsSkeleton
      v-if="status === 'loading'"
      label="Loading settings..."
    />

    <EmptyState
      v-else-if="status === 'error'"
      tone="error"
      title="Settings could not be loaded"
      description="Check your connection and try again."
    >
      <template #actions>
        <button
          type="button"
          class="btn-quiet"
          @click="loadSettings"
        >
          Try again
        </button>
      </template>
    </EmptyState>

    <EmptyState
      v-else-if="settings.length === 0"
      title="No settings available"
      description="There is nothing to configure for your account yet."
    />

    <SurfaceCard
      v-else
      class="max-w-3xl"
    >
      <ul class="divide-y divide-line">
        <li
          v-for="setting in settings"
          :key="setting.id"
        >
          <label
            v-if="setting.type === 'boolean'"
            class="flex cursor-pointer items-center justify-between gap-4 p-4"
          >
            <span class="min-w-0">
              <span class="block break-words text-sm font-medium text-ink">{{ setting.t_name || setting.name }}</span>
              <span
                class="mt-0.5 block text-sm text-muted"
                aria-live="polite"
              >{{ saving === setting.id ? 'Saving...' : (isOn(setting) ? 'On' : 'Off') }}</span>
            </span>

            <ToggleSwitch
              :id="`setting-${setting.id}`"
              :model-value="isOn(setting)"
              :disabled="saving === setting.id"
              @update:model-value="(v) => saveSetting(setting, v ? '1' : '0')"
            />
          </label>

          <form
            v-else
            class="grid gap-3 p-4 sm:grid-cols-[1fr_14rem_auto] sm:items-center"
            @submit.prevent="saveSetting(setting)"
          >
            <div class="min-w-0">
              <label
                :for="`setting-${setting.id}`"
                class="block break-words text-sm font-medium text-ink"
              >{{ setting.t_name || setting.name }}</label>
              <p class="mt-0.5 break-words text-sm text-muted">
                Current value: {{ setting.user_setting ? setting.user_setting.value : 'not set' }}
              </p>
            </div>

            <input
              :id="`setting-${setting.id}`"
              v-model="setting.user_value"
              type="text"
              class="app-input"
              required
            >

            <button
              type="submit"
              class="btn-quiet"
              :disabled="saving === setting.id"
            >
              {{ saving === setting.id ? 'Saving...' : 'Save' }}
            </button>
          </form>
        </li>
      </ul>
    </SurfaceCard>
  </PageSection>
</template>

<script>
import EmptyState from '../components/EmptyState.vue'
import PageSection from '../components/PageSection.vue'
import SettingsSkeleton from '../components/SettingsSkeleton.vue'
import SurfaceCard from '../components/SurfaceCard.vue'
import ToggleSwitch from '../components/ToggleSwitch.vue'

export default {
  name: 'SettingPage',

  components: {
    EmptyState,
    PageSection,
    SettingsSkeleton,
    SurfaceCard,
    ToggleSwitch
  },

  data () {
    return {
      status: 'loading',
      saving: null,
      settings: []
    }
  },

  created () {
    this.loadSettings()
  },

  methods: {
    async loadSettings () {
      this.status = 'loading'

      try {
        const r = await this.$http.get('/setting')
        this.settings = r.data
        this.status = 'ready'
      } catch (e) {
        this.status = 'error'
      }
    },

    isOn (setting) {
      return String(setting.user_value) === '1'
    },

    // value is passed by switches; text rows save what was typed
    async saveSetting (setting, value = setting.user_value) {
      const prev = setting.user_value
      setting.user_value = value
      this.saving = setting.id

      try {
        const r = await this.$http.post('/setting', { setting_id: setting.id, value })
        setting.user_setting = r.data
      } catch (e) {
        // revert so the control shows the stored value, the interceptor shows the error
        setting.user_value = prev
      } finally {
        this.saving = null
      }
    }
  }
}
</script>
