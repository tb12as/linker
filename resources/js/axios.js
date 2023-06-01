// axios
import axios from "axios";
import { notify } from "@kyvg/vue3-notification";

const baseURL = "/api";

let headers = {};
const token = localStorage.getItem("api-token") || null;
if (token) {
    headers = {
        Authorization: `Bearer ${localStorage.getItem("api-token")}`,
    };
}
let a = axios.create({
    baseURL,
    headers,
});

a.interceptors.response.use(
    (res) => {
        if (res.data.show_message) {
            notify({
                title: "Success",
                text: data.message,
            });
        }
        // return res;
        return Promise.resolve(res);
    },
    (error) => {
        notify({
            title: "Whoops!",
            type: "error",
            text: error.response.data.message,
        });

        if (error.response.status == 401) {
            localStorage.removeItem("api-token");
        }

        return Promise.reject(error);
    }
);

export default a;
