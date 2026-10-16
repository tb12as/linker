<template>
  <div
    v-if="isModalOpen"
    class="fixed inset-0 z-50 flex items-end justify-center p-4 sm:items-center"
    @keydown.esc="cancel"
  >
    <div
      class="absolute inset-0 bg-black/60"
      @click="cancel"
    />

    <div
      class="relative w-full max-w-md rounded-panel border border-line bg-panel p-5 shadow-[0_16px_40px_rgb(0_0_0_/_0.35)]"
      role="dialog"
      aria-modal="true"
      :aria-labelledby="titleId"
    >
      <h2
        :id="titleId"
        class="font-serif text-2xl text-ink"
      >
        {{ title }}
      </h2>
      <p
        v-if="description"
        class="mt-1 text-sm text-muted"
      >
        {{ description }}
      </p>

      <div class="mt-4 max-h-[55vh] overflow-y-auto">
        <slot />
      </div>

      <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
        <button
          ref="cancelButton"
          type="button"
          class="btn-quiet"
          @click="cancel"
        >
          {{ cancelText }}
        </button>
        <button
          type="button"
          :class="acceptClass"
          :disabled="busy"
          @click="$emit('accept')"
        >
          {{ busy ? busyText : acceptText }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
let uid = 0

export default {
  name: 'CustomModal',

  props: {
    title: {
      type: String,
      default: 'Confirmation'
    },
    description: {
      type: String,
      default: null
    },
    cancelText: {
      type: String,
      default: 'Cancel'
    },
    acceptText: {
      type: String,
      default: 'Accept'
    },
    busyText: {
      type: String,
      default: 'Working...'
    },
    busy: {
      type: Boolean,
      default: false
    },
    acceptClass: {
      type: String,
      default: 'btn-primary'
    }
  },

  emits: ['accept'],

  data () {
    return {
      isModalOpen: false,
      returnFocus: null,
      titleId: `modal-title-${++uid}`
    }
  },

  methods: {
    openModal () {
      this.returnFocus = document.activeElement
      this.isModalOpen = true
      this.$nextTick(() => this.$refs.cancelButton.focus())
    },

    cancel () {
      this.isModalOpen = false

      if (this.returnFocus && this.returnFocus.isConnected) {
        this.returnFocus.focus()
      }
    }
  }
}
</script>
