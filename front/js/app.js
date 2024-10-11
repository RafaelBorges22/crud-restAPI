import { Home } from './views/home.js';
import { Logs } from './views/logs.js';

const routes = [
  {
    path: '/',
    component: Home,
    inject: ['baseURL'],
  },
  {
    path: '/logs',
    component: Logs,
    inject: ['baseURL'],
  }
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
});

const App = {
  data() {
    return {};
  },
  template: `
    <div>
      <h1>Listagem de produtos</h1>
      <nav>
          <router-link to="/">Home</router-link> |
          <router-link to="/logs">Logs</router-link>
      </nav>

      <router-view></router-view>
    </div>
  `,
  setup() {
    const baseURL = 'http://localhost:3000/';
    return {
      baseURL,
    };
  },
  provide() {
    return {
      baseURL: this.baseURL,
    };
  }
}

const app = Vue.createApp(App);
app.use(router);
app.mount('#app');