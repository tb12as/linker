<template>
  <div class="md:container md:mx-auto mx-4">
    <div class="my-5 lg:w-3/4">
      <h1
        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-gray-300 my-4"
      >New Link</h1>

      <form @submit.prevent="sendNewLink">
        <div class="flex justify flex-wrap">
          <div class="my-2 w-full">
            <label for="title" class="text-gray-300">Title</label>
            <input
              v-model="form.title"
              required
              type="text"
              class="mr-1 bg-gray-50 outline-none border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="e.g Google drive portfolio link"
            />
          </div>

          <p class="text-gray-300">Link</p>
          <div class="flex w-full">
            <input
              v-model="form.link"
              required
              type="url"
              class="mr-1 bg-gray-50 outline-none border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="https://yourlink.com"
            />

            <input
              v-if="userIsPro"
              type="text"
              v-model="form.custom"
              class="bg-gray-50 w-1/2 outline-none border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Custom unique code"
            />
          </div>

          <div class="my-4">
            <label class="relative inline-flex items-center cursor-pointer">
              <input v-model="form.private" type="checkbox" value class="sr-only peer" />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
              ></div>
              <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Private</span>
            </label>
          </div>
        </div>

        <button
          type="submit"
          class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800 my-4"
        >Submit</button>
      </form>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      loading: false,
      form: {
        private: false,
      },
    };
  },

  computed: {
    ...mapState(["links", "user"]),

    userIsPro() {
      if (this.user) {
        return this.user.is_pro;
      }
      return false;
    },
  },

  beforeMount() {
    if (this.$route.params.id) {
      this.loadLink(this.$route.params.id);
    }
  },

  created() {
    if (this.userIsPro) {
      this.form.private = true;
    }
  },

  methods: {
    loadLink(code) {
      this.$http.get("/link/get/" + code).then((res) => {
        console.log(res);
        this.form = { ...res.data.data };
        if (this.userIsPro) {
          this.form.custom = res.data.data.code;
          this.form.private = res.data.data.is_private;
        }
      });
    },

    async sendNewLink() {
      console.log("sending...");
      if (this.loading) {
        return;
      }
      this.loading = true;

      if (!this.userIsPro) {
        delete this.form.private;
      }

      await this.$http
        .post("/link/create", this.form)
        .then((res) => {
          this.$router.push({ name: "user.link" });
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>