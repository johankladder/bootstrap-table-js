window.Vue = require('vue');

/**
 * Import all the Vue components that are needed. But not creating a new Vue instance.
 * In a 'default' laravel application this is already done.
 */
Vue.component('vue-table', require('./components/VueTable.vue'));
Vue.component('vue-table-header', require('./components/VueTableHeader.vue'));
Vue.component('vue-table-data', require('./components/VueTableData.vue'));