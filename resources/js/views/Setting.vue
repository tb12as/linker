<template>
  <div class="md:container md:mx-auto mx-4">
    <div class="my-5 lg:w-3/4">
      <h1
        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-gray-300 my-4"
      >
        Setting
      </h1>

      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 scrollbar">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th
              scope="col"
              class="px-6 py-3"
            >
              Name
            </th>
            <th
              scope="col"
              class="px-6 py-3"
            >
              Value
            </th>
            <th
              scope="col"
              class="px-6 py-3"
            >
              Value
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(v, i) in settings"
            :key="i"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <td class="px-6 py-4">
              {{ v.t_name||v.name }}
            </td>
            <td class="px-6 py-4">
              {{ v.user_setting? v.user_setting.value : '-' }}
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-1">
                <input
                  v-model="v.user_value"
                  required
                  type="text"
                  :placeholder="v.type[0].toUpperCase() + v.type.slice(1) + ' value'"
                  class="mr-1 bg-gray-50 outline-none border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                <button
                  class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-primary-300 rounded-lg text-sm px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-primary-800"
                  @click="saveSetting(v)"
                >
                  Save
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SettingPage',

  data () {
    return {
      settings: []
    }
  },

  beforeMount () {
    this.loadSettings()
  },

  methods: {
    loadSettings () {
      this.$http.get('/setting').then((r) => {
        this.settings = r.data
      })
    },

    saveSetting (setting) {
      const data = {
        setting_id: setting.id,
        value: setting.user_value
      }
      this.$http.post('/setting', data).then((res) => {
        this.loadSettings()
      })
    }
  }
}
</script>
