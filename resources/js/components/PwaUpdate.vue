<template>
  <div
    v-if="pwa.needRefresh"
    class="fixed inset-x-4 bottom-4 z-50 mx-auto flex max-w-md items-center gap-3 rounded-panel border border-line bg-panel p-3
      shadow-[0_12px_32px_rgb(28_28_28_/_0.12)]"
    role="status"
  >
    <p class="flex-1 pl-1 text-sm text-ink">
      A new version of Linker is available.
    </p>
    <button
      type="button"
      class="btn-quiet"
      @click="dismissUpdate"
    >
      Later
    </button>
    <button
      type="button"
      class="btn-primary"
      @click="applyUpdate"
    >
      Reload
    </button>
  </div>
</template>

<script>
import pwa, { applyUpdate, dismissUpdate } from '../pwa'

export default {
  data () {
    return {
      pwa
    }
  },

  methods: {
    applyUpdate,
    dismissUpdate
  }
}
</script>
