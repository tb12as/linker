<template>
  <div class="flex min-w-0 items-center gap-1">
    <a
      :href="href"
      target="_blank"
      rel="noreferrer"
      class="min-w-0 break-all rounded-control bg-chip px-2 py-1 font-mono text-sm text-ink ring-1 ring-inset ring-line hover:ring-muted"
    >{{ display }}</a>

    <button
      type="button"
      class="btn-icon"
      :aria-label="copied ? 'Copied' : 'Copy short link'"
      :title="copied ? 'Copied' : 'Copy'"
      @click="copy"
    >
      <Check
        v-if="copied"
        class="h-4 w-4"
      />
      <Copy
        v-else
        class="h-4 w-4"
      />
    </button>

    <span
      class="sr-only"
      aria-live="polite"
    >{{ copied ? 'Short link copied' : '' }}</span>
  </div>
</template>

<script>
import { notify } from '@kyvg/vue3-notification'
import { Check, Copy } from 'lucide-vue-next'

export default {
  components: {
    Check,
    Copy
  },

  props: {
    href: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      copied: false,
      timer: null
    }
  },

  computed: {
    display () {
      return this.href.replace(/^https?:\/\//, '')
    }
  },

  beforeUnmount () {
    clearTimeout(this.timer)
  },

  methods: {
    async copy () {
      try {
        await navigator.clipboard.writeText(this.href)
      } catch (e) {
        notify({ title: 'Copy failed', type: 'error', text: 'Select the link and copy it manually.' })
        return
      }

      this.copied = true
      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        this.copied = false
      }, 1500)
    }
  }
}
</script>
