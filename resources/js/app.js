
require('./bootstrap');

window.Vue = require('vue').default;

import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
    el: '#app',
});
