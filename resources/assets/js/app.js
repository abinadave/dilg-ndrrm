
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
require('./bootstrap');
Vue.use(VueRouter);
Vue.use(VueResource);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');

window.router = new VueRouter({
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
    {
      path: '/Facilities',
      name: 'facility',
      component: require('./components/facility/facility.vue')
    },
    {
      path: '/Manage/Province',
      name: 'manage-province',
      component: require('./components/manage/province/manage-province.vue')
    },
    {
      path: '/Manage/City-Municipality',
      name: 'manage-city-municipality',
      component: require('./components/manage/city-municipality/manage-city-municipality.vue')
    },
    {
      path: '/Manage/City-Municipality/:id',
      component: require('./components/city_all_tabs.vue')
    },
    { path: '/', redirect: '/officers' }
  ]
});

const app = new Vue({
  	router
}).$mount('#app');
