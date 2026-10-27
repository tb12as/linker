<template>
  <div class="min-h-screen">
    <notifications position="bottom right" />
    <PwaUpdate />
    <AppShell
      :is-dark="theme === 'dark'"
      @toggle-theme="toggleTheme"
    >
      <router-view />
    </AppShell>
  </div>
</template>

<script>
import AppShell from './AppShell.vue'
import PwaUpdate from './PwaUpdate.vue'

const THEME_STORAGE_KEY = 'theme'

export default {
  components: {
    AppShell,
    PwaUpdate
  },

  data () {
    return {
      // the blade head script already resolved the theme
      theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
    }
  },

  created () {
    this.$store.dispatch('getUser').then(() => {
      const path = this.$route.path
      const user = this.$store.state.user

      if (user && path == '/') {
        this.$router.push({ name: 'user.link' })
      }
    })
  },

  methods: {
    toggleTheme () {
      this.theme = this.theme === 'dark' ? 'light' : 'dark'
      document.documentElement.classList.toggle(
        'dark',
        this.theme === 'dark'
      )

      try {
        localStorage.setItem(THEME_STORAGE_KEY, this.theme)
      } catch (e) {
        // storage blocked, theme still applies for this visit
      }
    }
  }
}
</script>
