<template>
  <div class="app-theme min-h-screen text-slate-100 antialiased">
    <notifications position="top right" />
    <AppShell
      :is-dark="theme === 'dark'"
      @toggle-theme="toggleTheme"
    >
      <router-view v-slot="{ Component }">
        <transition
          name="page"
          mode="out-in"
        >
          <component :is="Component" />
        </transition>
      </router-view>
    </AppShell>
  </div>
</template>

<script>
import AppShell from './AppShell.vue'

const THEME_STORAGE_KEY = 'theme'

export default {
  components: {
    AppShell
  },

  data () {
    return {
      theme: 'dark'
    }
  },

  created () {
    this.theme = this.getStoredTheme()
    this.applyTheme(this.theme)
    this.$store.dispatch('getUser')
  },

  methods: {
    getStoredTheme () {
      const savedTheme = localStorage.getItem(THEME_STORAGE_KEY)
      return ['dark', 'light'].includes(savedTheme) ? savedTheme : 'dark'
    },

    applyTheme (theme) {
      document.documentElement.classList.toggle('dark', theme === 'dark')
      document.body.dataset.theme = theme
      localStorage.setItem(THEME_STORAGE_KEY, theme)
    },

    toggleTheme () {
      this.theme = this.theme === 'dark' ? 'light' : 'dark'
      this.applyTheme(this.theme)
    }
  }
}
</script>
