import { createApp } from "vue/dist/vue.esm-bundler.js";
import App from "./App.vue";
import router from "./router";

const app = createApp({});
app.use(router);

app.component("App", App);

app.mount("#app");
