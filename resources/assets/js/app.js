
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';

window.toastr = require('toastr');
window.Vue = require('vue');
window.Vue.use(VueRouter);

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

import homeIndex from './components/home/index.vue';
import clientCreate from './components/client/create.vue';
import clientIndex  from './components/client/index.vue';
import clientView from './components/client/view.vue';
import clientEdit from './components/client/edit.vue';
import requestIndex from './components/request/index.vue';
import requestCreate from './components/request/create.vue';
import requestCreateId from './components/request/createId.vue';
import requestView from './components/request/view.vue';
import productIndex from './components/product/index.vue';
import productCreate from './components/product/create.vue';

const routes = [
    {path: '/',components: {home : homeIndex},name: 'Home'},
    {path: '/client/index', component:clientIndex, name: 'clientIndex'},
    {path: '/client/create', component:clientCreate, name: 'clientCreate'},
    {path: '/client/view/:id', component:clientView, name:'clientView'},
    {path: '/clients/edit/:id', component:clientEdit, name: 'clientEdit'},
    {path: '/request/index', component:requestIndex, name: 'requestIndex'},
    {path: '/request/create', component:requestCreate, name: 'requestCreate'},
    {path: '/request/create/:id', component:requestCreateId, name: 'requestCreateId'},
    {path: '/request/view/:id', component:requestView, name: 'requestView'},
    {path: '/product/index', component:productIndex, name: 'productIndex'},
    {path: '/product/create', component:productCreate, nane: 'productCreate'},
]

const router = new VueRouter({routes});

const app = new Vue({router}).$mount('#app');


$(function(){
    $('.menu-item').click(function(el){
        $('.menu-item').children('ul').hide();
        $('.menu-item').removeClass('active');
        $(this).children('ul').toggle();
        if($(this).hasClass("active"))
        {
            $(this).removeClass("active");
        }
        else
        {
            $(this).addClass("active");
        }
    });
    $('.menu-item ul').click(function(ev){
        ev.stopPropagation();
    })
});
