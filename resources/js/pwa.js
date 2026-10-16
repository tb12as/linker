// install prompt + update notice state, shared by AppShell and PwaUpdate
import { reactive } from 'vue'
import { registerSW } from 'virtual:pwa-register'

const pwa = reactive({
  canInstall: false,
  needRefresh: false
})

let deferredPrompt = null
let updateSW = null

window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault()
  deferredPrompt = e
  pwa.canInstall = true
})

window.addEventListener('appinstalled', () => {
  deferredPrompt = null
  pwa.canInstall = false
})

export const initPwa = () => {
  if (!('serviceWorker' in navigator)) {
    return
  }

  updateSW = registerSW({
    onNeedRefresh () {
      pwa.needRefresh = true
    }
  })
}

export const install = async () => {
  if (!deferredPrompt) {
    return
  }

  deferredPrompt.prompt()
  await deferredPrompt.userChoice
  deferredPrompt = null
  pwa.canInstall = false
}

export const applyUpdate = () => {
  if (updateSW) {
    updateSW(true)
  }
}

export const dismissUpdate = () => {
  pwa.needRefresh = false
}

export default pwa
