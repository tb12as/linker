<template>
  <section class="pt-8 sm:pt-12">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div class="min-w-0">
        <h1 class="font-serif text-4xl leading-tight text-ink sm:text-5xl">
          {{ title }}
        </h1>
        <p
          v-if="description"
          class="mt-2 max-w-xl text-sm leading-6 text-muted"
        >
          {{ description }}
        </p>
      </div>

      <div
        v-if="$slots.actions"
        class="flex shrink-0 flex-wrap items-center gap-2"
      >
        <slot name="actions" />
      </div>
    </div>

    <div class="mt-6">
      <slot />
    </div>
  </section>
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
