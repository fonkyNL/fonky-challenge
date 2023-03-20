import { createApp } from "vue";
import Dashboard from "./modules/dashboard/pages/Dashboard.vue";
import { VueQueryPlugin } from "@tanstack/vue-query";

const app = createApp({
  components: {
    Dashboard,
  },
});

app.use(VueQueryPlugin);

app.mount("#app");
