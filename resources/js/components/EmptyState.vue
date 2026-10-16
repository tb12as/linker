<template>
  <div
    class="rounded-panel border border-dashed px-6 py-10 text-center"
    :class="tone === 'error' ? 'border-danger' : 'border-muted/50'"
    :role="tone === 'error' ? 'alert' : null"
  >
    <h2 class="text-base font-semibold text-ink">
      {{ title }}
    </h2>
    <p
      v-if="description"
      class="mx-auto mt-2 max-w-md text-sm leading-6 text-muted"
    >
      {{ description }}
    </p>
    <div
      v-if="$slots.actions"
      class="mt-5 flex justify-center"
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
    },
    tone: {
      type: String,
      default: 'empty'
    }
  }
}
</script>
