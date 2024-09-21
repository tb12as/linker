<template>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
          >Create a short link</h1>

          <form class="space-y-4 md:space-y-6" @submit.prevent="sendForm">
            <CustomInput
              v-model="form.link"
              type="url"
              name="link"
              id="link"
              :required="true"
              placeholder="https://a-very-long-link.example"
            />

            <CustomInput
              :label="'Your short link'"
              id="short"
              v-model="form.short"
              type="text"
              readonly
              :disabled="form.short === ''"
              placeholder="lnkr.pw/r/[code]"
              @click="form.short === '' ? () => {} : copyToClipboard(form.short)"
            />

            <button
              type="submit"
              class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed"
              :disabled="loading || !form.link || form.link == ''"
            >Create Link</button>
          </form>

          <p class="text-gray-100">
            Already have an account? Log in
            <router-link to="/login" class="underline">Here</router-link>
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import CustomInput from "../components/CustomInput.vue";

import { notify } from "@kyvg/vue3-notification";

export default {
  components: {
    CustomInput,
  },

  data() {
    return {
      loading: false,
      waiting: undefined,
      form: {
        link: "",
        short: "",
      },
    };
  },

  methods: {
    async copyURL(mytext) {
      try {
        await navigator.clipboard.writeText(mytext);
        notify({
          title: "Success!",
          type: "success",
          text: "Copied to clipboard",
        });
      } catch ($e) {
        // console.log($e);
        // alert("Cannot copy");
      }
    },

    copyToClipboard(text) {
      clearTimeout(this.waiting);
      this.waiting = setTimeout(() => {
        this.copyURL(text);
      }, 300);
    },

    async getIp() {
      const data = await fetch("https://api.ipify.org?format=json");
      const json = await data.json();
      return json.ip || null;
    },

    async generateTitle() {
      const titles = ["Anonymous Link"];
      const ip = await this.getIp();
      titles.push(ip || "Unknown IP");

      return titles.join(" - ");
    },

    async sendForm() {
      const { link } = this.form;
      if (!link) {
        return;
      }

      this.loading = true;
      this.form.title = await this.generateTitle();
      console.log(this.form);

      await this.$http
        .post("/link/create", this.form, {
          headers: {
            "Content-Type": "application/json",
            Authorization: ``,
          },
        })
        .then((res) => {
          const link = res.data.data || undefined;
          if (!link) {
            return;
          }

          this.form.short = link.short_link;
          if (this.form.short) {
            // remove https:// or http:// from short link
            this.form.short = this.form.short.replace("https://", "");
            this.form.short = this.form.short.replace("http://", "");
          }
        })
        .finally(() => {
          setTimeout(() => {
            this.loading = false;
          }, 1000);
        });
    },
  },
};
</script>

