<template>
  <div>
    <label
      v-if="label"
      :for="id"
      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
    >{{ label }}</label>

    <input
      v-model="localValue"
      :type="type"
      :name="name"
      :id="id"
      :placeholder="placeholder"
      :class="inputClass + (disabled ? 'hover:cursor-not-allowed' : '')"
      :required="required"
      :disabled="disabled"
      :readonly="readonly"
      @input="$emit('update:modelValue', localValue)"
      @click.prevent="$emit('click')"
    />
  </div>
</template>
  
  <script>
export default {
  props: {
    modelValue: {
      type: String,
      required: false,
      default: "",
    },
    required: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    readonly: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      default: null,
    },
    type: {
      type: String,
      default: "url",
    },
    name: {
      type: String,
      default: "",
    },
    id: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    inputClass: {
      type: String,
      default: `bg-gray-50 border border-gray-300 text-gray-900 outline-none sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500`,
    },
  },
  computed: {
    localValue: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
};
</script>
  