import { createRouter, createWebHistory } from "vue-router";
import store from "./store/index";

// 1. Define route components.
// These can be imported from other files
import Home from "./components/ExampleComponent.vue";
import Login from "./views/Login.vue";
import Link from "./views/Link.vue";
import NotFound from "./views/404.vue";
import Public from "./views/Public.vue";

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
    // { path: '/', component: Home },
    { path: "/", component: Public, name: "public" },
    { path: "/login", component: Login, name: "login" },
    {
        path: "/links",
        component: Link,
        name: "user.link",
        meta: {
            authRequired: true,
        },
    },
    {
        path: "/links/create",
        component: () => import("./views/Form.vue"),
        name: "link.create",
        meta: {
            authRequired: true,
        },
    },
    {
        path: "/links/:id/edit",
        component: () => import("./views/Form.vue"),
        name: "link.edit",
        meta: {
            authRequired: true,
        },
    },
    {
        path: "/settings",
        component: () => import("./views/Setting.vue"),
        name: "setting",
        meta: {
            authRequired: true,
        },
    },
    {
        path: "/:pathMatch(.*)*",
        component: NotFound,
        name: "not-found",
    },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    history: createWebHistory(),
    mode: "history",
    routes, // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    if (to.meta.authRequired) {
        if (!store.state.user && !localStorage.getItem("api-token")) {
            router.push({ name: "login", query: { to: to.path } });
        }
    } else {
        if (store.state.user) {
            // redirect to home links page
        }
    }

    return next();
});

export default router;
