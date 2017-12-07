
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
import Paginate from 'vuejs-paginate';
import VueCharts from 'vue-chartjs'
import { Bar, Line } from 'vue-chartjs'

window.toastr = require('toastr');
window.Vue = require('vue');
window.Vue.use(VueRouter);
// window.charts = require('vue-chartjs');

Vue.component('paginate', Paginate);

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
import productView from './components/product/view.vue';
import orderIndex from './components/order/index.vue';
import orderCreate from './components/order/create.vue';
import orderCreateId from './components/order/createId.vue';
import orderView from './components/order/view.vue';
import search from './components/search.vue';
import searchPage from './components/searchPage.vue';
import settingsProfile from './components/settings/profile.vue';

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
    {path: '/product/view/:id', component:productView, name: 'productView'},
    {path: '/product/create', component:productCreate, name: 'productCreate'},
    {path: '/order/index', component:orderIndex, name: 'orderIndex'},
    {path: '/order/create', component:orderCreate, name: 'orderCreate'},
    {path: '/order/create/:id', component:orderCreateId, name: 'orderCreateId'},
    {path: '/order/view/:id', component:orderView, name: 'orderView'},
    {path: '/search', component:searchPage, name: 'search'},
    {path: '/settings/profile', component:settingsProfile, name: 'settingsProfile'},
]

Vue.mixin({
    components:{
        search:search
    },
    data(){
        return {
            itemsList: [],
            perPage: 20,
            currentPage: 0,
            resultsCount: 0,
            pageNumber: 1,
        }
    },
    methods:{
        goBack(){
            this.$router.go(-1);
        },
        paginate(list){
            (list) ? this.resultsCount = list.length : false;

            var index = (this.pageNumber * this.perPage) - 20;

            if(this.pageNumber == 1){
                index = 0;
            }

            return (list) ? list.slice(index, index + this.perPage) : false;
        },
        pageResult(pageNumber){
            this.pageNumber = pageNumber;
            this.paginate(this.orders);
        },
    },
    computed:{
        totalPages(){
            return Math.ceil(this.resultsCount/this.perPage);
        },
    },
});

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
