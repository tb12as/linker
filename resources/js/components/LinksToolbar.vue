<template>
  <SurfaceCard class="p-3 sm:p-4">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
      <div class="relative flex-1">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-app-muted">
          <svg
            class="h-5 w-5"
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path d="m21 21-4.35-4.35" />
            <circle
              cx="11"
              cy="11"
              r="6"
            />
          </svg>
        </span>
        <input
          :value="modelValue"
          type="text"
          class="app-input pl-10"
          placeholder="Search"
          @input="$emit('update:modelValue', $event.target.value)"
        >
      </div>

      <div class="flex flex-col gap-2 sm:flex-row">
        <router-link
          :to="{ name: 'link.create' }"
          class="inline-flex items-center justify-center gap-2 rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
        >
          <Plus class="h-4 w-4" />
          New
        </router-link>
        <router-link
          :to="{ name: 'setting' }"
          class="inline-flex items-center justify-center gap-2 rounded-md border border-app-border px-4 py-2.5 text-sm font-medium text-app-text transition hover:bg-app-muted-panel"
        >
          <Settings class="h-4 w-4" />
          Settings
        </router-link>
      </div>
    </div>
  </SurfaceCard>
</template>

<script>
import { Plus, Settings } from 'lucide-vue-next'
import SurfaceCard from './SurfaceCard.vue'

export default {
  components: {
    Plus,
    Settings,
    SurfaceCard
  },

  props: {
    modelValue: {
      type: String,
      default: ''
    }
  },

  emits: ['update:modelValue']
}
</script>
