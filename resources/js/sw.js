import { cleanupOutdatedCaches, precacheAndRoute } from 'workbox-precaching'
import { registerRoute } from 'workbox-routing'
import { CacheFirst, StaleWhileRevalidate } from 'workbox-strategies'
import { ExpirationPlugin } from 'workbox-expiration'
import { CacheableResponsePlugin } from 'workbox-cacheable-response'

// built js/css injected by vite-plugin-pwa, relative to public/build, while
// the worker itself is served from /sw.js
precacheAndRoute(self.__WB_MANIFEST.map((entry) => ({ ...entry, url: `/build/${entry.url}` })))
cleanupOutdatedCaches()

const SHELL_CACHE = 'app-shell'
const SHELL_KEY = '/'

// never touched by the worker: short link redirects (view counts), api, tools
const BYPASS = ['/r/', '/api/', '/64', '/adminer', '/sw.js']

const isBypassed = (pathname) => BYPASS.some((p) => pathname === p.replace(/\/$/, '') || pathname.startsWith(p))

// every page is the same Vue shell, so keep the latest copy and serve it offline
registerRoute(
  ({ request, url }) => request.mode === 'navigate' && url.origin === self.location.origin && !isBypassed(url.pathname),
  async ({ request }) => {
    const cache = await caches.open(SHELL_CACHE)

    try {
      const res = await fetch(request)

      if (res.ok && !res.redirected) {
        cache.put(SHELL_KEY, res.clone())
      }

      return res
    } catch (e) {
      const cached = await cache.match(SHELL_KEY)

      return cached || Response.error()
    }
  }
)

registerRoute(
  ({ url }) => url.origin === 'https://fonts.googleapis.com',
  new StaleWhileRevalidate({ cacheName: 'google-fonts-css' })
)

registerRoute(
  ({ url }) => url.origin === 'https://fonts.gstatic.com',
  new CacheFirst({
    cacheName: 'google-fonts',
    plugins: [
      new CacheableResponsePlugin({ statuses: [0, 200] }),
      new ExpirationPlugin({ maxEntries: 20, maxAgeSeconds: 60 * 60 * 24 * 365 })
    ]
  })
)

registerRoute(
  ({ request, url }) => request.destination === 'image' && url.origin === self.location.origin && url.pathname.startsWith('/icons/'),
  new StaleWhileRevalidate({ cacheName: 'icons' })
)

// the page asks for this when the user accepts the update notice
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting()
  }
})
