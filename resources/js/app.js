// import './bootstrap';

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';
// u vite.config dodat alias ziggy
import { ZiggyVue } from "ziggy";
import '../css/app.css';
import { InertiaProgress } from "@inertiajs/progress";

// progress bar
InertiaProgress.init({
  delay: 0,
  color: '#29d',
  includeCSS: true,
  showSpinner: true,
})

createInertiaApp({
  resolve: async (name) => {
    const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
    const page = await pages[`./Pages/${name}.vue`];
    page.default.layout = page.default.layout || MainLayout

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .mount(el);
  },
});
