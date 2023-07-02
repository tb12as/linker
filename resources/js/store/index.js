import { createStore } from "vuex";
import http from "../axios";

const store = createStore({
    state() {
        return {
            user: null,
            link_search: null,
            links: [],
        };
    },
    mutations: {
        setSearch(state, n) {
            state.link_search = n;
        },

        setUser(state, user) {
            state.user = user;
        },
        setLinks(state, links) {
            state.links = links;
        },
    },
    actions: {
        async getUser({ commit, state }) {
            if (!localStorage.getItem("api-token")) {
                commit("setUser", null);
                return;
            }

            if (state.user !== null) return;

            await http
                .post("/get-user")
                .then((res) => {
                    commit("setUser", res.data);
                })
                .catch((err) => {
                    localStorage.removeItem("api-token");
                    commit("setUser", null);
                });
        },

        async getLinks({ commit, state }) {
            const params = {};
            if (state.link_search) {
                params["search"] = state.link_search;
            }

            await http.get("/link/mine", { params }).then((res) => {
                commit("setLinks", res.data.data);
            });
        },
    },
});

export default store;
