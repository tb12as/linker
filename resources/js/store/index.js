import { createStore } from "vuex";
import http from "../axios";

const store = createStore({
    state() {
        return {
            user: null,
            link_search: null,
            page: 1,
            next_page: null,
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
        setNextPage(state, page) {
            state.next_page = page;
        },
        setPage(state, val) {
            state.page = val;
        },
        mergeState(state, val) {
            const old = state.links;
            const newState = [...old, ...val];
            state.links = newState;
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

        async getLinks({ commit, state }, merge = false) {
            const params = {};
            if (state.link_search) {
                params["search"] = state.link_search;
            }

            params["page"] = state.page;

            await http.get("/link/mine", { params }).then((res) => {
                commit("setNextPage", res.data.links.next);

                if (merge) {
                    commit("mergeState", res.data.data);
                } else {
                    commit("setLinks", res.data.data);
                }
            });
        },

        removeLink({ commit, state }, code) {
            const links = state.links.filter((link) => link.code !== code);
            commit("setLinks", links);
        },
    },
});

export default store;
