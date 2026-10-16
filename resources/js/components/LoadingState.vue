<template>
  <div
    class="flex items-center justify-center gap-2 py-6 text-sm text-muted"
    role="status"
  >
    <span class="h-4 w-4 animate-spin rounded-full border-2 border-muted/40 border-t-accent motion-reduce:animate-none" />
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
