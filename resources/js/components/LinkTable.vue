<template>
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
          v-for="link in links"
          :key="link.code"
          class="border-b border-line last:border-b-0 hover:bg-subtle/50"
        >
          <td class="px-4 py-2 align-middle">
            <p class="line-clamp-2 break-words font-medium text-ink">
              {{ link.title }}
            </p>
            <span
              v-if="link.is_private"
              class="mt-1 inline-block rounded-control border border-muted/60 px-1.5 text-xs text-muted"
            >Private</span>
          </td>
          <td class="px-4 py-2 align-middle">
            <ShortLink :href="link.short_link" />
          </td>
          <td class="px-4 py-2 align-middle">
            <p
              class="line-clamp-2 break-all text-muted"
              :title="link.link"
            >
              {{ link.link }}
            </p>
          </td>
          <td class="px-4 py-2 align-middle text-muted">
            {{ link.expire_at || 'Never' }}
          </td>
          <td class="px-2 py-2 align-middle">
            <div class="flex justify-end">
              <router-link
                :to="{ name: 'link.edit', params: { id: link.code } }"
                class="btn-icon"
                :aria-label="`Edit ${link.title}`"
                title="Edit"
              >
                <Pencil class="h-4 w-4" />
              </router-link>
              <button
                type="button"
                class="btn-icon hover:text-danger"
                :aria-label="`Delete ${link.title}`"
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
  </SurfaceCard>
</template>

<script>
import { Pencil, Trash2 } from 'lucide-vue-next'
import ShortLink from './ShortLink.vue'
import SurfaceCard from './SurfaceCard.vue'

export default {
  components: {
    Pencil,
    ShortLink,
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
