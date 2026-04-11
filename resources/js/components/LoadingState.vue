<template>
  <div class="flex items-center justify-center gap-2 py-5 text-sm text-app-muted">
    <span class="h-4 w-4 animate-spin rounded-full border-2 border-blue-400/30 border-t-blue-500 dark:border-blue-300/20 dark:border-t-blue-400" />
    <span>{{ label }}</span>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: 'Loading...'
    }
  }
}
</script>
