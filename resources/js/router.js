import { createRouter, createWebHistory } from "vue-router";

const routerHistory = createWebHistory();

const router = createRouter({
  history: routerHistory,
  routes: [
    {
      path: "/",
      component: () => import("./pages/Main.vue"),
    },
    {
      path: "/about",
      component: () => import("./pages/About.vue"),
    },
  ],
});

export default router;
