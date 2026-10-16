<template>
  <div class="flex flex-col gap-2 sm:flex-row">
    <div class="relative flex-1">
      <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted" />
      <input
        :value="modelValue"
        type="search"
        class="app-input pl-9"
        placeholder="Search by title or code"
        aria-label="Search links"
        @input="$emit('update:modelValue', $event.target.value)"
      >
    </div>

    <router-link
      :to="{ name: 'link.create' }"
      class="btn-primary"
    >
      New link
    </router-link>
  </div>
</template>

<script>
import { Search } from 'lucide-vue-next'

export default {
  components: {
    Search
  },

  props: {
    modelValue: {
      type: String,
      default: ''
    }
  },

  emits: ['update:modelValue']
}
</script>
