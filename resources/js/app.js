require('./bootstrap');
import Vue from 'vue'
import router from './router'

window.Vue = require('vue');

Vue.component('chat-app', require('./components/ChatApp'));

new Vue({
    router,
}).$mount('#app')

// const app = new Vue({
//     mode: 'history',
//     router,
//     el: '#app',
//     render : h => h(App)
// });
