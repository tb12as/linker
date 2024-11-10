<template>
  <notifications />
  <router-view />
</template>

<script>
export default {
  beforeCreate () {
    this.$store.dispatch('getUser')
  }
}
</script>
