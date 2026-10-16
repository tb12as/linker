<template>
  <div
    role="status"
    :aria-label="label"
  >
    <SurfaceCard class="hidden overflow-hidden md:block">
      <table class="w-full table-fixed text-sm">
        <thead class="border-b border-line bg-subtle text-left text-muted">
          <tr>
            <th class="w-[24%] px-4 py-3 font-medium">
              Title
            </th>
            <th class="w-[26%] px-4 py-3 font-medium">
              Short link
            </th>
            <th class="px-4 py-3 font-medium">
              Destination
            </th>
            <th class="w-28 px-4 py-3 font-medium">
              Expires
            </th>
            <th class="w-28 px-4 py-3">
              <span class="sr-only">Actions</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="n in rows"
            :key="n"
            class="border-b border-line last:border-b-0"
          >
            <td class="px-4 py-4">
              <SkeletonBlock
                class="h-4"
                :style="{ width: widths[n % widths.length] }"
              />
            </td>
            <td class="px-4 py-4">
              <SkeletonBlock class="h-4 w-3/4" />
            </td>
            <td class="px-4 py-4">
              <SkeletonBlock
                class="h-4"
                :style="{ width: widths[(n + 2) % widths.length] }"
              />
            </td>
            <td class="px-4 py-4">
              <SkeletonBlock class="h-4 w-14" />
            </td>
            <td class="px-4 py-4">
              <div class="flex justify-end gap-3">
                <SkeletonBlock class="h-6 w-6" />
                <SkeletonBlock class="h-6 w-6" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </SurfaceCard>

    <SurfaceCard class="md:hidden">
      <ul class="divide-y divide-line px-4">
        <li
          v-for="n in rows"
          :key="n"
          class="py-4"
        >
          <div class="flex items-start justify-between gap-4">
            <div class="min-w-0 flex-1 space-y-2">
              <SkeletonBlock
                class="h-4"
                :style="{ width: widths[n % widths.length] }"
              />
              <SkeletonBlock class="h-3 w-24" />
            </div>
            <div class="flex shrink-0 gap-3">
              <SkeletonBlock class="h-6 w-6" />
              <SkeletonBlock class="h-6 w-6" />
            </div>
          </div>
          <SkeletonBlock class="mt-3 h-4 w-40" />
          <SkeletonBlock class="mt-2 h-3 w-4/5" />
        </li>
      </ul>
    </SurfaceCard>

    <span class="sr-only">{{ label }}</span>
  </div>
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
      default: 5
    },
    label: {
      type: String,
      default: 'Loading...'
    }
  },

  data () {
    // varied widths so rows don't look like a stamped grid
    return {
      widths: ['70%', '55%', '85%', '62%', '78%']
    }
  }
}
</script>
