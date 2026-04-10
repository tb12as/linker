<template>
  <PageSection
    title="Page not found"
    section-class="py-6 md:py-12"
  >
    <SurfaceCard class="mx-auto max-w-md p-5 text-center">
      <p class="text-5xl font-semibold text-app-text">
        404
      </p>
      <p class="mt-3 text-sm text-app-muted">
        The page could not be found.
      </p>

      <router-link
        :to="{ path: '/' }"
        class="mt-5 inline-flex rounded-lg bg-app-button px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
      >
        Go Home
      </router-link>
    </SurfaceCard>
  </PageSection>
</template>

<script>
import PageSection from '../components/PageSection.vue'
import SurfaceCard from '../components/SurfaceCard.vue'

export default {
  name: 'NotFound',

  components: {
    PageSection,
    SurfaceCard
  }
}
</script>
