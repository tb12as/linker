import { createStore } from "vuex";
import http from "../axios";

const store = createStore({
    state() {
        return {
            user: null,
        };
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
    },
    actions: {
        async getUser({ commit }) {
            if (!localStorage.getItem("api-token")) return;

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
    },
});

export default store;
