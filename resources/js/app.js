import { createApp } from 'vue';
require('./bootstrap');
require('./fontawesome');

let app=createApp({})
app.component('user-info', require('./components/UserInfo.vue').default);
app.mount("#app")