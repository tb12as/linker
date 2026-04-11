<template>
  <div class="rounded-lg border border-dashed border-app-border p-6 text-center">
    <h2 class="text-base font-semibold text-app-text">
      {{ title }}
    </h2>
    <p class="mx-auto mt-2 max-w-md text-sm text-app-muted">
      {{ description }}
    </p>
    <div
      v-if="$slots.actions"
      class="mt-4 flex justify-center"
    >
      <slot name="actions" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      default: ''
    }
  }
}
</script>
