import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import Dashboard from './components/Dashboard.vue';

Vue.use(BootstrapVue);

new Vue({
    el: '#dashboard',
    template: '<Dashboard />',
    components: { Dashboard }
});
