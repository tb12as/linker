<template>
  <transition
    name="modal-fade"
    appear
  >
    <div
      v-if="isModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
      <div
        class="absolute inset-0 bg-slate-950/70"
        @click="cancel"
      />

      <transition
        name="modal-scale"
        appear
      >
        <div
          v-if="isModalOpen"
          class="relative z-10 w-full max-w-sm overflow-hidden rounded-lg border border-app-border bg-app-panel-soft p-3 shadow-soft"
        >
          <div class="flex items-start justify-between gap-3">
            <div>
              <h2 class="text-base font-semibold text-app-text">
                {{ title }}
              </h2>
              <p
                v-if="description"
                class="mt-1 text-xs text-app-muted"
              >
                {{ description }}
              </p>
            </div>

            <button
              type="button"
              class="inline-flex items-center justify-center rounded-md border border-app-border p-1.5 text-app-muted hover:bg-app-muted-panel hover:text-app-text"
              aria-label="Close modal"
              @click="cancel"
            >
              <X class="h-4 w-4" />
            </button>
          </div>

          <div class="mt-3 max-h-[55vh] overflow-y-auto pr-1">
            <slot />
          </div>

          <div class="mt-3 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
            <button
              type="button"
              class="inline-flex items-center justify-center gap-2 rounded-md border border-app-border px-3 py-2 text-sm font-medium text-app-text hover:bg-app-muted-panel"
              @click="cancel"
            >
              <X class="h-4 w-4" />
              {{ cancelText }}
            </button>
            <button
              type="button"
              class="inline-flex items-center justify-center gap-2 rounded-md px-3 py-2 text-sm font-medium"
              :class="acceptClass"
              @click="handleAccept"
            >
              <Check class="h-4 w-4" />
              {{ acceptText }}
            </button>
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
import { Check, X } from 'lucide-vue-next'

export default {
  name: 'CustomModal',

  components: {
    Check,
    X
  },

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
    acceptClass: {
      type: String,
      default: 'bg-app-button text-white rounded-lg hover:opacity-90'
    },
    onAccept: {
      type: Function,
      default: () => {}
    }
  },

  emits: ['accept'],

  data () {
    return {
      isModalOpen: false
    }
  },

  methods: {
    openModal () {
      this.isModalOpen = true
    },

    cancel () {
      this.isModalOpen = false
    },

    handleAccept () {
      this.$emit('accept')
    }
  }
}
</script>
