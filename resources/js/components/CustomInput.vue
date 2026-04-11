<template>
  <div :class="containerClass">
    <label
      v-if="label"
      :for="id"
      :class="labelClass"
    >{{ label }}</label>

    <input
      :id="id"
      v-model="localValue"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      :autocomplete="autocomplete"
      :class="inputClass + (disabled ? ' cursor-not-allowed opacity-60' : '')"
      :required="required"
      :disabled="disabled"
      :readonly="readonly"
      @input="$emit('update:modelValue', localValue)"
      @click.prevent="$emit('click')"
    >

    <p
      v-if="helper"
      class="app-helper"
    >
      {{ helper }}
    </p>
  </div>
</template>
  
<script>
export default {
  props: {
    modelValue: {
      type: String,
      required: false,
      default: ''
    },
    required: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    readonly: {
      type: Boolean,
      default: false
    },
    label: {
      type: String,
      default: null
    },
    type: {
      type: String,
      default: 'url'
    },
    name: {
      type: String,
      default: ''
    },
    id: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    helper: {
      type: String,
      default: ''
    },
    autocomplete: {
      type: String,
      default: 'off'
    },
    containerClass: {
      type: String,
      default: ''
    },
    labelClass: {
      type: String,
      default: 'app-label'
    },
    inputClass: {
      type: String,
      default: 'app-input'
    }
  },
  emits: ['update:modelValue', 'click'],
  computed: {
    localValue: {
      get () {
        return this.modelValue
      },
      set (value) {
        this.$emit('update:modelValue', value)
      }
    }
  }
}
</script>
  
