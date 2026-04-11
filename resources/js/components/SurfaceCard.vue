<template>
  <div :class="cardClass">
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    cardClass: {
      type: String,
      default: 'rounded-xl border border-app-border bg-app-panel-soft p-4 shadow-soft'
    }
  }
}
</script>
