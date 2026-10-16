<template>
  <div
    class="max-w-xl space-y-5"
    role="status"
    :aria-label="label"
  >
    <div
      v-for="n in fields"
      :key="n"
      class="space-y-2"
    >
      <SkeletonBlock class="h-4 w-28" />
      <SkeletonBlock class="h-11 w-full" />
    </div>

    <div class="flex items-center justify-between gap-4 rounded-panel border border-line bg-panel p-4">
      <div class="flex-1 space-y-2">
        <SkeletonBlock class="h-4 w-24" />
        <SkeletonBlock class="h-3 w-44" />
      </div>
      <SkeletonBlock class="h-7 w-12 rounded-full" />
    </div>

    <SkeletonBlock class="h-11 w-32" />
    <span class="sr-only">{{ label }}</span>
  </div>
</template>

<script>
import SkeletonBlock from './SkeletonBlock.vue'

export default {
  components: {
    SkeletonBlock
  },

  props: {
    fields: {
      type: Number,
      default: 2
    },
    label: {
      type: String,
      default: 'Loading...'
    }
  }
}
</script>
