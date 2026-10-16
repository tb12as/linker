<template>
  <span class="relative inline-flex shrink-0 items-center">
    <input
      :id="id"
      type="checkbox"
      role="switch"
      class="peer sr-only"
      :checked="modelValue"
      :disabled="disabled"
      @change="$emit('update:modelValue', $event.target.checked)"
    >
    <span
      class="h-7 w-12 rounded-full bg-muted/50 peer-checked:bg-accent peer-disabled:opacity-50
        peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2
        peer-focus-visible:outline-accent"
    />
    <span class="absolute left-1 top-1 h-5 w-5 rounded-full bg-panel shadow-sm peer-checked:translate-x-5" />
  </span>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: Boolean,
      default: false
    },
    id: {
      type: String,
      default: null
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },

  emits: ['update:modelValue']
}
</script>
