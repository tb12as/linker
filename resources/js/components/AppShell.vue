<template>
  <div class="min-h-screen">
    <header
      class="border-b border-line bg-canvas/95"
      @keydown.esc="closeMenus"
    >
      <div class="mx-auto flex h-16 max-w-5xl items-center gap-2 px-4 sm:px-6">
        <router-link
          :to="brandTarget"
          class="mr-6 inline-flex min-h-[44px] items-center font-serif text-2xl text-ink"
        >
          Linker
        </router-link>

        <nav
          v-if="user"
          class="hidden items-center gap-1 md:flex"
          aria-label="Main"
        >
          <router-link
            v-for="item in nav"
            :key="item.name"
            :to="{ name: item.name }"
            class="inline-flex h-16 items-center border-b-2 px-3 text-sm font-medium"
            :class="isActive(item.name) ? 'border-ink text-ink' : 'border-transparent text-muted hover:text-ink'"
            :aria-current="isActive(item.name) ? 'page' : null"
          >
            {{ item.label }}
          </router-link>
        </nav>

        <div class="ml-auto flex items-center gap-1">
          <div
            v-if="user"
            ref="account"
            class="relative hidden md:block"
          >
            <button
              ref="accountButton"
              type="button"
              class="btn gap-1.5 px-3 text-ink hover:bg-subtle"
              aria-controls="account-menu"
              :aria-expanded="isAccountOpen ? 'true' : 'false'"
              @click="isAccountOpen = !isAccountOpen"
            >
              <span class="max-w-[12rem] truncate">{{ user.username }}</span>
              <ChevronDown
                class="h-4 w-4 text-muted"
                :class="isAccountOpen ? 'rotate-180' : ''"
              />
            </button>

            <div
              v-if="isAccountOpen"
              id="account-menu"
              class="absolute right-0 top-full z-40 mt-1 w-48 rounded-panel border border-line bg-panel p-1
                shadow-[0_12px_32px_rgb(28_28_28_/_0.12)]"
            >
              <router-link
                :to="{ name: 'setting' }"
                class="flex min-h-[44px] items-center rounded-control px-3 text-sm text-ink hover:bg-subtle"
              >
                Settings
              </router-link>
              <button
                type="button"
                class="flex min-h-[44px] w-full items-center rounded-control px-3 text-sm text-ink hover:bg-subtle"
                @click="logout"
              >
                Sign out
              </button>
            </div>
          </div>

          <router-link
            v-else-if="!user && $route.name !== 'login'"
            :to="{ name: 'login' }"
            class="btn-quiet"
          >
            Sign in
          </router-link>

          <ThemeToggle
            :is-dark="isDark"
            @toggle="$emit('toggle-theme')"
          />

          <button
            v-if="user"
            type="button"
            class="btn-icon md:hidden"
            aria-controls="mobile-menu"
            :aria-expanded="isMobileMenuOpen ? 'true' : 'false'"
            aria-label="Menu"
            @click="isMobileMenuOpen = !isMobileMenuOpen"
          >
            <XIcon
              v-if="isMobileMenuOpen"
              class="h-5 w-5"
            />
            <MenuIcon
              v-else
              class="h-5 w-5"
            />
          </button>
        </div>
      </div>

      <nav
        v-if="user && isMobileMenuOpen"
        id="mobile-menu"
        class="border-t border-line px-4 pb-3 pt-2 md:hidden"
        aria-label="Main"
      >
        <p class="truncate py-2 text-sm text-muted">
          Signed in as {{ user.username }}
        </p>

        <router-link
          v-for="item in [...nav, { name: 'setting', label: 'Settings' }]"
          :key="item.name"
          :to="{ name: item.name }"
          class="flex min-h-[44px] items-center rounded-control px-2 text-base"
          :class="isActive(item.name) ? 'font-semibold text-ink' : 'text-muted hover:text-ink'"
          :aria-current="isActive(item.name) ? 'page' : null"
        >
          {{ item.label }}
        </router-link>

        <button
          type="button"
          class="flex min-h-[44px] w-full items-center rounded-control px-2 text-base text-muted hover:text-ink"
          @click="logout"
        >
          Sign out
        </button>
      </nav>
    </header>

    <main class="mx-auto max-w-5xl px-4 pb-16 sm:px-6">
      <slot />
    </main>
  </div>
</template>

<script>
import { ChevronDown, Menu as MenuIcon, X as XIcon } from 'lucide-vue-next'
import ThemeToggle from './ThemeToggle.vue'

const nav = [
  { name: 'user.link', label: 'Links' },
  { name: 'link.create', label: 'New link' }
]

export default {
  components: {
    ChevronDown,
    MenuIcon,
    ThemeToggle,
    XIcon
  },

  props: {
    isDark: {
      type: Boolean,
      default: false
    }
  },

  emits: ['toggle-theme'],

  data () {
    return {
      nav,
      isMobileMenuOpen: false,
      isAccountOpen: false
    }
  },

  computed: {
    user () {
      return this.$store.state.user
    },

    brandTarget () {
      return this.user ? { name: 'user.link' } : { name: 'public' }
    }
  },

  watch: {
    $route () {
      this.isMobileMenuOpen = false
      this.isAccountOpen = false
    },

    isAccountOpen (open) {
      // close on any click outside the account menu
      if (open) {
        document.addEventListener('click', this.onOutsideClick)
      } else {
        document.removeEventListener('click', this.onOutsideClick)
      }
    }
  },

  beforeUnmount () {
    document.removeEventListener('click', this.onOutsideClick)
  },

  methods: {
    isActive (name) {
      return this.$route.name === name
    },

    onOutsideClick (e) {
      if (!this.$refs.account || !this.$refs.account.contains(e.target)) {
        this.isAccountOpen = false
      }
    },

    closeMenus () {
      if (this.isAccountOpen) {
        this.isAccountOpen = false
        this.$refs.accountButton.focus()
      }

      this.isMobileMenuOpen = false
    },

    logout () {
      localStorage.removeItem('api-token')
      this.$store.commit('setUser', null)
      this.$store.commit('setLinks', [])
      this.$store.commit('setSearch', null)
      this.isMobileMenuOpen = false
      this.isAccountOpen = false
      this.$router.push({ name: 'login' })
    }
  }
}
</script>
