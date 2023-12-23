<template>
  <div>
    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 p-4">
      <!-- Background overlay -->
      <div @click="cancel" class="fixed inset-0 bg-black opacity-50 cursor-pointer"></div>

      <!-- Modal container -->
      <div
        class="bg-gray-800 p-2 px-4 rounded-md shadow-lg z-10 lg:w-1/3 sm:w-1/2 w-full overflow-x-scroll"
        style="max-width:600px;"
      >
        <!-- Modal content -->
        <div class="text-white">
          <h2 class="text-xl font-bold mb-4">{{ title }}</h2>

          <p class="my-4" v-if="description">{{ description }}</p>
          <slot></slot>

          <div class="flex justify-end gap-2">
            <button
              @click="cancel"
              class="text-sm p-1 px-3 bg-gray-700 text-white rounded hover:bg-gray-600"
            >{{ cancelText }}</button>
            <button
              @click="handleAccept"
              class="text-sm p-1 px-3"
              :class="acceptClass"
            >{{ acceptText }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  props: {
    title: {
      type: String,
      default: "Confirmation",
    },
    description: {
      type: String,
      default: null,
    },
    cancelText: {
      type: String,
      default: "Cancel",
    },
    acceptText: {
      type: String,
      default: "Accept",
    },
    acceptClass: {
      type: String,
      default: "bg-blue-700 text-white rounded hover:bg-blue-600",
    },
    onAccept: Function, // New prop to handle custom accept actions
  },
  data() {
    return {
      isModalOpen: false,
    };
  },
  methods: {
    openModal() {
      this.isModalOpen = true;
    },
    cancel() {
      this.isModalOpen = false;
    },
    handleAccept() {
      this.$emit("accept")
      // if (this.onAccept && typeof this.onAccept === "function") {
      //   // If onAccept prop is provided, call the custom accept function
      //   this.onAccept();
      // } else {
      //   // Default behavior: close the modal
      //   this.isModalOpen = false;
      // }
    },
  },
};
</script>
  
