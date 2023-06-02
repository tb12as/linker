import { createStore } from "vuex";
import http from "../axios";

const store = createStore({
    state() {
        return {
            user: null,
            links: [],
        };
    },
    mutations: {
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
            await http.get("/link/mine").then((res) => {
                commit("setLinks", res.data.data);
            });
        },
    },
});

export default store;
