<template>
  <PageSection :title="isEditing ? 'Edit link' : 'New link'">
    <FormSkeleton
      v-if="status === 'loading'"
      :fields="userIsPro ? 3 : 2"
      label="Loading link..."
    />

    <EmptyState
      v-else-if="status === 'error'"
      tone="error"
      title="This link could not be loaded"
      description="It may have been deleted, or the connection dropped."
    >
      <template #actions>
        <router-link
          :to="{ name: 'user.link' }"
          class="btn-quiet"
        >
          Back to links
        </router-link>
      </template>
    </EmptyState>

    <form
      v-else
      class="max-w-xl space-y-5"
      @submit.prevent="sendNewLink"
    >
      <CustomInput
        id="title"
        v-model="form.title"
        label="Title"
        type="text"
        helper="Only you see this. It helps you find the link later."
        :required="true"
      />

      <CustomInput
        id="link"
        v-model="form.link"
        label="Destination URL"
        type="url"
        placeholder="https://example.com/page"
        :required="true"
        autocomplete="url"
      />

      <CustomInput
        v-if="userIsPro"
        id="custom"
        v-model="form.custom"
        label="Custom code"
        type="text"
        helper="At least 3 characters. Leave empty for a random code."
      />

      <label
        class="flex items-center justify-between gap-4 rounded-panel border border-line bg-panel p-4"
        :class="userIsPro ? 'cursor-pointer' : 'cursor-not-allowed'"
      >
        <span class="min-w-0">
          <span class="block text-sm font-medium text-ink">Private link</span>
          <span class="mt-0.5 block text-sm text-muted">
            {{ userIsPro ? 'Hidden from public search.' : 'Available on Pro accounts.' }}
          </span>
        </span>

        <ToggleSwitch
          v-model="form.private"
          :disabled="!userIsPro"
        />
      </label>

      <div class="flex flex-col gap-3 pt-1 sm:flex-row sm:items-center">
        <button
          type="submit"
          class="btn-primary"
          :disabled="loading"
        >
          {{ submitText }}
        </button>

        <router-link
          :to="{ name: 'user.link' }"
          class="text-link self-center"
        >
          Back to links
        </router-link>
      </div>
    </form>
  </PageSection>
</template>

<script>
import { mapState } from 'vuex'
import CustomInput from '../components/CustomInput.vue'
import EmptyState from '../components/EmptyState.vue'
import FormSkeleton from '../components/FormSkeleton.vue'
import PageSection from '../components/PageSection.vue'
import ToggleSwitch from '../components/ToggleSwitch.vue'

export default {
  name: 'LinkForm',

  components: {
    CustomInput,
    EmptyState,
    FormSkeleton,
    PageSection,
    ToggleSwitch
  },

  data () {
    return {
      status: this.$route.params.id ? 'loading' : 'ready',
      loading: false,
      form: {
        private: false
      }
    }
  },

  computed: {
    ...mapState(['user']),

    userIsPro () {
      return Boolean(this.user && this.user.is_pro)
    },

    isEditing () {
      return Boolean(this.$route.params.id)
    },

    submitText () {
      if (this.loading) {
        return 'Saving...'
      }

      return this.isEditing ? 'Save changes' : 'Create short link'
    }
  },

  created () {
    if (this.userIsPro) {
      this.form.private = true
    }

    if (this.isEditing) {
      this.loadLink(this.$route.params.id)
    }
  },

  methods: {
    async loadLink (code) {
      try {
        const res = await this.$http.get(`/link/get/${code}`)
        this.form = { ...res.data.data }

        if (this.userIsPro) {
          this.form.custom = res.data.data.code
          this.form.private = res.data.data.is_private
        }

        this.status = 'ready'
      } catch (e) {
        this.status = 'error'
      }
    },

    async sendNewLink () {
      if (this.loading) {
        return
      }

      this.loading = true

      const body = { ...this.form }
      if (!this.userIsPro) {
        delete body.private
      }

      try {
        await this.$http.post('/link/create', body)
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
