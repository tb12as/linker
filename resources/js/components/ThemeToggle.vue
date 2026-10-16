<template>
  <button
    type="button"
    class="btn-icon"
    :aria-label="isDark ? 'Switch to light theme' : 'Switch to dark theme'"
    :title="isDark ? 'Light theme' : 'Dark theme'"
    @click="$emit('toggle')"
  >
    <Sun
      v-if="isDark"
      class="h-4 w-4"
    />
    <Moon
      v-else
      class="h-4 w-4"
    />
  </button>
</template>

<script>
import { Moon, Sun } from 'lucide-vue-next'

export default {
  components: {
    Moon,
    Sun
  },

  props: {
    isDark: {
      type: Boolean,
      default: true
    }
  },

  emits: ['toggle']
}
</script>
