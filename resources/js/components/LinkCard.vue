<template>
  <li class="min-w-0 py-4">
    <div class="flex items-start justify-between gap-2">
      <div class="min-w-0">
        <p class="break-words font-medium text-ink">
          {{ link.title }}
        </p>
        <p class="mt-0.5 text-xs text-muted">
          <span v-if="link.is_private">Private · </span>Expires: {{ link.expire_at || 'never' }}
        </p>
      </div>

      <div class="-mr-2 -mt-2 flex shrink-0">
        <router-link
          :to="{ name: 'link.edit', params: { id: link.code } }"
          class="btn-icon"
          :aria-label="`Edit ${link.title}`"
        >
          <Pencil class="h-4 w-4" />
        </router-link>
        <button
          type="button"
          class="btn-icon hover:text-danger"
          :aria-label="`Delete ${link.title}`"
          @click="$emit('delete', link.code)"
        >
          <Trash2 class="h-4 w-4" />
        </button>
      </div>
    </div>

    <ShortLink
      class="mt-2"
      :href="link.short_link"
    />

    <p class="mt-1 line-clamp-2 break-all text-sm text-muted">
      {{ link.link }}
    </p>
  </li>
</template>

<script>
import { Pencil, Trash2 } from 'lucide-vue-next'
import ShortLink from './ShortLink.vue'

export default {
  components: {
    Pencil,
    ShortLink,
    Trash2
  },

  props: {
    link: {
      type: Object,
      required: true
    }
  },

  emits: ['delete']
}
</script>
