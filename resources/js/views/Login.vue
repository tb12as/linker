<template>
  <PageSection
    title="Sign in"
    section-class="py-3 md:py-6"
  >
    <SurfaceCard class="max-w-md p-4 sm:p-5">
      <form
        class="space-y-4"
        @submit.prevent="sendLogin"
      >
        <CustomInput
          id="username"
          v-model="form.username"
          label="Username"
          type="text"
          name="username"
          autocomplete="username"
          placeholder="Your username"
          :required="true"
        />

        <CustomInput
          id="password"
          v-model="form.password"
          label="Password"
          type="password"
          name="password"
          autocomplete="current-password"
          placeholder="••••••••"
          :required="true"
        />

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
          <button
            type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
          >
            Sign in
          </button>

          <router-link
            :to="{ name: 'public' }"
            class="text-sm text-app-muted hover:text-app-text"
          >
            Back
          </router-link>
        </div>
      </form>
    </SurfaceCard>
  </PageSection>
</template>

<script>
import CustomInput from '../components/CustomInput.vue'
import PageSection from '../components/PageSection.vue'
import SurfaceCard from '../components/SurfaceCard.vue'

export default {
  name: 'LoginPage',

  components: {
    CustomInput,
    PageSection,
    SurfaceCard
  },

  data () {
    return {
      form: {
        username: '',
        password: ''
      }
    }
  },

  created () {
    this.$store.dispatch('getUser').then(() => {
      if (this.$store.state.user) {
        this.$router.push({ name: 'user.link' })
      }
    })
  },

  methods: {
    async sendLogin () {
      await this.$http
        .post('/login', this.form)
        .then((res) => {
          localStorage.setItem('api-token', res.data.data.token)
          this.$store.commit('setUser', res.data.data.user)
          this.$router.push({ name: 'user.link' })
        })
        .catch(() => {})
    }
  }
}
</script>
