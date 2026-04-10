<template>
  <SurfaceCard class="flex h-full flex-col p-0 overflow-hidden md:hidden">
    <div class="flex items-start justify-between gap-3 p-4">
      <div class="space-y-2 min-w-0">
        <div class="flex flex-wrap items-center gap-2">
          <span
            v-if="link.is_private"
            class="inline-flex rounded-md bg-amber-500/15 px-2 py-0.5 text-xs font-medium text-amber-300"
          >
            Private
          </span>
        </div>
        <div>
          <h3 class="truncate text-base font-semibold text-app-text">
            {{ link.title }}
          </h3>
          <p class="mt-1 text-xs text-app-muted">
            {{ link.expire_at || 'No expiry' }}
          </p>
        </div>
      </div>

      <button
        type="button"
        class="inline-flex items-center justify-center rounded-md border border-app-border p-2 text-app-muted transition hover:bg-app-muted-panel hover:text-app-text"
        aria-label="Delete link"
        title="Delete"
        @click="$emit('delete', link.code)"
      >
        <Trash2 class="h-4 w-4" />
      </button>
    </div>

    <div class="grid gap-3 px-4 py-3">
      <div>
        <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-app-muted">
          Short
        </p>
        <a
          :href="link.short_link"
          target="_blank"
          rel="noreferrer"
          class="mt-1 block break-all text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300"
        >
          {{ link.short_link }}
        </a>
      </div>

      <div>
        <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-app-muted">
          Target
        </p>
        <p class="mt-1 line-clamp-3 break-all text-sm leading-5 text-app-text-soft">
          {{ link.link }}
        </p>
      </div>
    </div>

    <div class="mt-auto flex gap-2 p-4">
      <router-link
        :to="{ name: 'link.edit', params: { id: link.code } }"
        class="inline-flex flex-1 items-center justify-center gap-2 rounded-md border border-app-border px-3 py-2 text-sm font-medium text-app-text transition hover:bg-app-muted-panel"
      >
        <Pencil class="h-4 w-4" />
        Edit
      </router-link>
      <button
        type="button"
        class="inline-flex flex-1 items-center justify-center gap-2 rounded-md border border-app-border px-3 py-2 text-sm font-medium text-app-muted transition hover:bg-app-muted-panel hover:text-app-text"
        @click="$emit('delete', link.code)"
      >
        <Trash2 class="h-4 w-4" />
        Delete
      </button>
    </div>
  </SurfaceCard>
</template>

<script>
import { Pencil, Trash2 } from 'lucide-vue-next'
import SurfaceCard from './SurfaceCard.vue'

export default {
  components: {
    Pencil,
    SurfaceCard,
    Trash2
  },

  props: {
    link: {
      type: Object,
      required: true
    },
    index: {
      type: Number,
      default: 0
    }
  },

  emits: ['delete']
}
</script>
