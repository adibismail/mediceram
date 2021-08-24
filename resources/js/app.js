import Vue from "vue";
import axios from 'axios';
import VueAxios from 'vue-axios';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import { App, plugin } from "@inertiajs/inertia-vue";
import VueMeta from "vue-meta";
import {Ziggy} from './ziggy';
import route from '../../vendor/tightenco/ziggy/dist';
import VueMask from 'v-mask';

Vue.use(VueAxios, axios);
Vue.config.productionTip = false;
Vue.use(plugin);
Vue.use(VueMeta);
Vue.use(Vuetify);
Vue.use(VueMask);

// local - npm run watch
// live - npm run production

Vue.mixin({
  methods: {
      // php artisan ziggy:generate to re-generate route file when routes change
      route: (name, params, absolute) => route(name, params, absolute, Ziggy),
  },
});

const el = document.getElementById("app");

new Vue({
    metaInfo: {
        titleTemplate: title => (title ? `${title} - Mediceram` : "Mediceram")
    },
    vuetify: new Vuetify(),
    render: h =>
        h(App, {
            props: {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: name => require(`./Pages/${name}`).default
            }
        })
}).$mount(el);