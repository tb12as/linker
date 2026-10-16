<template>
  <PageSection title="Sign in">
    <form
      class="max-w-sm space-y-4"
      @submit.prevent="sendLogin"
    >
      <CustomInput
        id="username"
        v-model="form.username"
        label="Username"
        type="text"
        name="username"
        autocomplete="username"
        :required="true"
      />

      <CustomInput
        id="password"
        v-model="form.password"
        label="Password"
        type="password"
        name="password"
        autocomplete="current-password"
        :required="true"
      />

      <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
        <button
          type="submit"
          class="btn-primary sm:w-32"
          :disabled="loading"
        >
          {{ loading ? 'Signing in...' : 'Sign in' }}
        </button>

        <router-link
          :to="{ name: 'public' }"
          class="text-link self-center"
        >
          Shorten without an account
        </router-link>
      </div>
    </form>
  </PageSection>
</template>

<script>
import CustomInput from '../components/CustomInput.vue'
import PageSection from '../components/PageSection.vue'

export default {
  name: 'LoginPage',

  components: {
    CustomInput,
    PageSection
  },

  data () {
    return {
      loading: false,
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
      if (this.loading) {
        return
      }

      this.loading = true

      try {
        const res = await this.$http.post('/login', this.form)
        localStorage.setItem('api-token', res.data.data.token)
        this.$store.commit('setUser', res.data.data.user)
        this.$router.push({ name: 'user.link' })
      } catch (e) {
        // the axios interceptor already shows the error
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
