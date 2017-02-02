
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import VueRouter from 'vue-router'

require('./bootstrap');
Vue.use(VueRouter);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
  routes: [
    {
      path: '/Officers',
      name: 'officers',
      component: require('./components/officer/officer.vue')
    },
    {
      path: '/Rescue/Team/',
      name: 'rescues',
      component: require('./components/rescue/rescue.vue')
    },
    {
      path: '/Evacuations',
      name: 'evacuation',
      component: require('./components/evacuation/evacuation.vue')
    },
    { path: '/', redirect: '/officers' }
  ]
});

const app = new Vue({
  	router
}).$mount('#app');
