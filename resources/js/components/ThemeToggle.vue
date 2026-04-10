<template>
  <button
    type="button"
    class="inline-flex items-center gap-2 rounded-md border border-app-border bg-app-muted-panel px-2.5 py-1.5 text-sm font-medium text-app-text transition hover:bg-white/10"
    @click="$emit('toggle')"
  >
    <span class="relative flex h-6 w-10 items-center rounded-full bg-slate-200/80 p-1 transition dark:bg-slate-800/90">
      <span
        class="absolute h-4 w-4 rounded-full bg-white transition-transform dark:bg-slate-100"
        :class="isDark ? 'translate-x-4' : 'translate-x-0'"
      />
    </span>
    <span>{{ isDark ? 'Dark' : 'Light' }}</span>
  </button>
</template>

<script>
export default {
  props: {
    isDark: {
      type: Boolean,
      default: true
    }
  },

  emits: ['toggle']
}
</script>
