<template>
  <PageSection
    title="Page not found"
    description="This address does not match any page in Linker."
  >
    <router-link
      :to="{ path: '/' }"
      class="btn-primary"
    >
      Back to Linker
    </router-link>
  </PageSection>
</template>

<script>
import PageSection from '../components/PageSection.vue'

export default {
  name: 'NotFound',

  components: {
    PageSection
  }
}
</script>
