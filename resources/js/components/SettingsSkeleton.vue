<template>
  <SurfaceCard
    class="max-w-3xl"
    role="status"
    :aria-label="label"
  >
    <ul class="divide-y divide-line">
      <li
        v-for="n in rows"
        :key="n"
        class="flex items-center justify-between gap-4 p-4"
      >
        <div class="min-w-0 flex-1 space-y-2">
          <SkeletonBlock
            class="h-4"
            :style="{ width: n % 2 ? '40%' : '55%' }"
          />
          <SkeletonBlock class="h-3 w-16" />
        </div>
        <SkeletonBlock class="h-7 w-12 rounded-full" />
      </li>
    </ul>
    <span class="sr-only">{{ label }}</span>
  </SurfaceCard>
</template>

<script>
import SkeletonBlock from './SkeletonBlock.vue'
import SurfaceCard from './SurfaceCard.vue'

export default {
  components: {
    SkeletonBlock,
    SurfaceCard
  },

  props: {
    rows: {
      type: Number,
      default: 3
    },
    label: {
      type: String,
      default: 'Loading...'
    }
  }
}
</script>
