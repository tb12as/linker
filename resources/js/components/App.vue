<template>
  <notifications />
  <router-view></router-view>
</template>

<script>
export default {
  created() {
    this.$store.dispatch("getUser");
  },
};
</script>
