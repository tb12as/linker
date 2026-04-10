<template>
  <SurfaceCard class="hidden overflow-hidden p-0 md:block">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="border-b border-app-border bg-app-muted-panel-soft text-left">
          <tr class="text-app-muted">
            <th class="px-4 py-3 font-medium">
              Title
            </th>
            <th class="px-4 py-3 font-medium">
              Short
            </th>
            <th class="px-4 py-3 font-medium">
              Target
            </th>
            <th class="px-4 py-3 font-medium">
              Expiry
            </th>
            <th class="px-4 py-3 font-medium text-right">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="link in links"
            :key="link.code"
            class="border-b border-app-border last:border-b-0"
          >
            <td class="px-4 py-3 align-top">
              <div class="flex items-center gap-2">
                <span class="font-medium text-app-text">{{ link.title }}</span>
                <span
                  v-if="link.is_private"
                  class="inline-flex rounded-md bg-amber-500/15 px-2 py-0.5 text-[11px] font-medium text-amber-300"
                >
                  Private
                </span>
              </div>
            </td>
            <td class="px-4 py-3 align-top">
              <a
                :href="link.short_link"
                target="_blank"
                rel="noreferrer"
                class="break-all font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300"
              >
                {{ link.short_link }}
              </a>
            </td>
            <td class="max-w-md px-4 py-3 align-top">
              <p class="line-clamp-2 break-all text-app-text-soft">
                {{ link.link }}
              </p>
            </td>
            <td class="px-4 py-3 align-top text-app-muted">
              {{ link.expire_at || 'No expiry' }}
            </td>
            <td class="px-4 py-3 align-top">
              <div class="flex justify-end gap-2">
                <router-link
                  :to="{ name: 'link.edit', params: { id: link.code } }"
                  class="inline-flex items-center justify-center rounded-md border border-app-border p-2 text-app-text transition hover:bg-app-muted-panel"
                  aria-label="Edit link"
                  title="Edit"
                >
                  <Pencil class="h-4 w-4" />
                </router-link>
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
            </td>
          </tr>
        </tbody>
      </table>
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
    links: {
      type: Array,
      required: true
    }
  },

  emits: ['delete']
}
</script>
