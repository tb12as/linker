<template>
  <section :class="sectionClass">
    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
      <div class="space-y-1">
        <p
          v-if="eyebrow"
          class="text-[11px] font-semibold uppercase tracking-[0.24em] text-app-muted"
        >
          {{ eyebrow }}
        </p>
        <h1 class="text-2xl font-semibold tracking-tight text-app-text sm:text-3xl">
          {{ title }}
        </h1>
        <p
          v-if="description"
          class="max-w-2xl text-sm text-app-muted"
        >
          {{ description }}
        </p>
      </div>

      <div
        v-if="$slots.actions"
        class="flex flex-wrap items-center gap-2"
      >
        <slot name="actions" />
      </div>
    </div>

    <div
      v-if="$slots.default"
      class="mt-5"
    >
      <slot />
    </div>
  </section>
</template>

<script>
export default {
  props: {
    eyebrow: {
      type: String,
      default: ''
    },
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      default: ''
    },
    sectionClass: {
      type: String,
      default: 'py-4'
    }
  }
}
</script>
