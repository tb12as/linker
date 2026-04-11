<template>
  <div class="min-h-screen bg-app text-app-text transition-colors duration-300">
    <header class="relative z-10 px-4 py-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-7xl rounded-xl border border-app-border bg-app-panel-soft px-4 py-3 shadow-soft">
        <div class="flex items-center justify-between gap-3">
          <router-link
            :to="brandTarget"
            class="inline-flex items-center gap-2"
          >
            <Link2 class="h-4 w-4 text-app-muted" />
            <span class="text-base font-semibold text-app-text">Linker</span>
          </router-link>

          <button
            type="button"
            class="inline-flex items-center justify-center rounded-md border border-app-border bg-app-muted-panel p-2 text-app-text md:hidden"
            :aria-expanded="isMobileMenuOpen ? 'true' : 'false'"
            aria-label="Toggle navigation menu"
            @click="toggleMobileMenu"
          >
            <XIcon
              v-if="isMobileMenuOpen"
              class="h-4 w-4"
            />
            <MenuIcon
              v-else
              class="h-4 w-4"
            />
          </button>

          <div class="hidden md:flex md:flex-1 md:items-center md:justify-between md:gap-3">
            <nav
              v-if="user"
              class="ml-6 flex flex-wrap items-center gap-2"
            >
              <router-link
                v-for="item in authenticatedNav"
                :key="item.name"
                :to="{ name: item.name }"
                class="inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium transition"
                :class="isActive(item.name) ? 'bg-app-muted-panel text-app-text' : 'text-app-muted hover:text-app-text'"
              >
                <component
                  :is="item.icon"
                  class="h-4 w-4"
                />
                <span>{{ item.label }}</span>
              </router-link>
            </nav>

            <div class="flex items-center gap-2">
              <ThemeToggle
                :is-dark="isDark"
                @toggle="$emit('toggle-theme')"
              />

              <template v-if="user">
                <div class="hidden items-center gap-2 rounded-md border border-app-border bg-app-muted-panel px-3 py-1.5 text-sm text-app-muted lg:inline-flex">
                  <User class="h-4 w-4" />
                  <span>{{ user.username }}</span>
                </div>
                <button
                  type="button"
                  class="inline-flex items-center justify-center gap-2 rounded-lg bg-app-button px-3 py-1.5 text-sm font-medium text-white transition hover:opacity-90"
                  @click="logout"
                >
                  <LogOut class="h-4 w-4" />
                  <span>Logout</span>
                </button>
              </template>

              <template v-else>
                <router-link
                  v-if="$route.name !== 'public'"
                  :to="{ name: 'public' }"
                  class="inline-flex items-center justify-center gap-2 rounded-md border border-app-border px-3 py-1.5 text-sm font-medium text-app-text transition hover:bg-app-muted-panel"
                >
                  <House class="h-4 w-4" />
                  <span>Home</span>
                </router-link>
                <router-link
                  v-if="$route.name !== 'login'"
                  :to="{ name: 'login' }"
                  class="inline-flex items-center justify-center gap-2 rounded-lg bg-app-button px-3 py-1.5 text-sm font-medium text-white transition hover:opacity-90"
                >
                  <LogIn class="h-4 w-4" />
                  <span>Sign in</span>
                </router-link>
              </template>
            </div>
          </div>
        </div>

        <div
          v-if="isMobileMenuOpen"
          class="mt-3 border-t border-app-border pt-3 md:hidden"
        >
          <div class="grid gap-2">
            <template v-if="user">
              <div class="inline-flex items-center gap-2 rounded-md border border-app-border bg-app-muted-panel px-3 py-2 text-sm text-app-muted">
                <User class="h-4 w-4" />
                <span>{{ user.username }}</span>
              </div>

              <router-link
                v-for="item in authenticatedNav"
                :key="item.name"
                :to="{ name: item.name }"
                class="inline-flex items-center gap-3 rounded-md border border-app-border px-3 py-2 text-sm font-medium text-app-text transition hover:bg-app-muted-panel"
                @click="closeMobileMenu"
              >
                <component
                  :is="item.icon"
                  class="h-4 w-4 text-app-muted"
                />
                <span>{{ item.label }}</span>
              </router-link>
            </template>

            <template v-else>
              <router-link
                v-if="$route.name !== 'public'"
                :to="{ name: 'public' }"
                class="inline-flex items-center gap-3 rounded-md border border-app-border px-3 py-2 text-sm font-medium text-app-text transition hover:bg-app-muted-panel"
                @click="closeMobileMenu"
              >
                <House class="h-4 w-4 text-app-muted" />
                <span>Home</span>
              </router-link>
              <router-link
                v-if="$route.name !== 'login'"
                :to="{ name: 'login' }"
                class="inline-flex items-center gap-3 rounded-lg bg-app-button px-3 py-2 text-sm font-medium text-white transition hover:opacity-90"
                @click="closeMobileMenu"
              >
                <LogIn class="h-4 w-4" />
                <span>Sign in</span>
              </router-link>
            </template>

            <button
              type="button"
              class="inline-flex items-center gap-3 rounded-md border border-app-border px-3 py-2 text-sm font-medium text-app-text transition hover:bg-app-muted-panel"
              @click="toggleThemeFromMenu"
            >
              <Sun
                v-if="isDark"
                class="h-4 w-4 text-app-muted"
              />
              <Moon
                v-else
                class="h-4 w-4 text-app-muted"
              />
              <span>{{ isDark ? 'Light mode' : 'Dark mode' }}</span>
            </button>

            <button
              v-if="user"
              type="button"
              class="inline-flex items-center gap-3 rounded-lg bg-app-button px-3 py-2 text-sm font-medium text-white transition hover:opacity-90"
              @click="logout"
            >
              <LogOut class="h-4 w-4" />
              <span>Logout</span>
            </button>
          </div>
        </div>
      </div>
    </header>

    <main class="relative z-10 px-4 pb-8 sm:px-6 lg:px-8 lg:pb-10">
      <div class="mx-auto max-w-7xl">
        <slot />
      </div>
    </main>
  </div>
</template>

<script>
import { House, Link2, LogIn, LogOut, Menu as MenuIcon, Moon, Plus, Settings, Sun, User, X as XIcon } from 'lucide-vue-next'
import ThemeToggle from './ThemeToggle.vue'

export default {
  components: {
    House,
    Link2,
    LogIn,
    LogOut,
    MenuIcon,
    Moon,
    Plus,
    Settings,
    Sun,
    ThemeToggle,
    User,
    XIcon
  },

  props: {
    isDark: {
      type: Boolean,
      default: true
    }
  },

  emits: ['toggle-theme'],

  data () {
    return {
      isMobileMenuOpen: false
    }
  },

  computed: {
    user () {
      return this.$store.state.user
    },

    brandTarget () {
      return this.user ? { name: 'user.link' } : { name: 'public' }
    },

    authenticatedNav () {
      return [
        { name: 'user.link', label: 'Links', icon: Link2 },
        { name: 'link.create', label: 'New Link', icon: Plus },
        { name: 'setting', label: 'Settings', icon: Settings }
      ]
    }
  },

  watch: {
    $route () {
      this.closeMobileMenu()
    }
  },

  methods: {
    isActive (name) {
      return this.$route.name === name
    },

    toggleMobileMenu () {
      this.isMobileMenuOpen = !this.isMobileMenuOpen
    },

    closeMobileMenu () {
      this.isMobileMenuOpen = false
    },

    toggleThemeFromMenu () {
      this.$emit('toggle-theme')
      this.closeMobileMenu()
    },

    logout () {
      localStorage.removeItem('api-token')
      this.$store.commit('setUser', null)
      this.$store.commit('setLinks', [])
      this.$store.commit('setSearch', null)
      this.closeMobileMenu()
      this.$router.push({ name: 'login' })
    }
  }
}
</script>
