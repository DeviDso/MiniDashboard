<template>
    <div>
        <div class="col-md-9">
            <div class="desa-container">
                <h1>{{ client.name }}</h1>
                <hr>
                <table class="clientInfo">
                    <tr>
                        <td><i class="fa fa-user"></i> {{ client.contact_person}}</td>
                        <td><i class="fa fa-phone"></i>{{ client.phone }}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope"></i>{{ client.email }}</td>
                        <td><i class="fa fa-home"></i>{{ client.street + ' ' + client.post_code + ', ' + client.city + ', ' + client.country }}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-id-card"></i>{{ client.vat }}</td>
                        <td><i class="fa fa-map-marker"></i>{{ client.delivery_street + ' ' + client.delivery_post_code + ', ' + client.delivery_city + ', ' + client.delivery_country }}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-calendar-plus-o"></i>{{ client.payment_term }}</td>
                        <td><i class="fa fa-credit-card"></i>{{ client.credit_amount }} days</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-truck"></i>{{ client.courier_account }}</td>
                        <td><i class="fa fa-sticky-note"></i>{{ client.note }}</td>
                    </tr>
                </table>
                <!-- <hr> -->
                <!-- <div class="col-md-12" v-if="!requestSection">
                    <h3>No request records!</h3>
                    <hr>
                </div> -->
                <div class="col-md-12" v-if="requestSection">
                    <h2>Statistics</h2>
                    <!-- <div class="col-md-6" v-if="reqStatistics">
                        <request-statistics :data="chartData" :height="275"/>
                    </div> -->
                    <div class="col-md-12">
                        <sale-statistics :height="275"/>
                    </div>
                    <hr>
                    <!-- <h2>Requests</h2>
                    <div class="col-md-6">
                        <h3>Active</h3>
                        <table class="col-md-12">
                            <thead>
                                <td>Request</td>
                                <td>Date</td>
                                <td>Status</td>
                            </thead>
                            <tr v-for="(request, index) in active(client.requests)" v-on:click="openRequest(request.id)">
                                <td>{{ request.request_type.name }}</td>
                                <td>{{ request.created_at.substr(0, 10) }}</td>
                                <td v-bind:class="requestStatus(request.request_status.id)"> {{request.request_status.name}}</td>
                            </tr>
                        </table>
                        <div class="col-md-12" v-if="activeMore">
                            <button type="button" v-on:click="viewMore('active')" class="viewMore">View all</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>History</h3>
                        <table class="col-md-12">
                            <thead>
                                <td>Request</td>
                                <td>Date</td>
                                <td>Status</td>
                            </thead>
                            <tr v-for="(request, index) in history(client.requests)" v-on:click="openRequest(request.id)">
                                <td>{{ request.request_type.name }}</td>
                                <td>{{ request.created_at.substr(0, 10) }}</td>
                                <td v-bind:class="requestStatus(request.request_status.id)"> {{request.request_status.name}}</td>
                            </tr>
                        </table>
                        <div class="col-md-12" v-if="historyMore">
                            <button type="button" v-on:click="viewMore('history')" class="viewMore">View all</button>
                        </div>
                    </div> -->
                </div>
                <div class="col-md-12" v-if="!ordersSection">
                    <h3>No order records!</h3>
                    <hr>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h2>Quotes</h2>
                    <table class="col-md-12">
                        <thead>
                            <td>#</td>
                            <td>Delivery price</td>
                            <td>Number of products</td>
                            <td>Total value</td>
                            <td>Date</td>
                        </thead>
                        <tr v-for="(quote, index) in client.quote" v-on:click="openQuote(quote.id)">
                            <td>{{ index+1 }}</td>
                            <td>{{ quote.delivery_price }} &euro;</td>
                            <td>{{ quote.data.length }}</td>
                            <td>{{ countOrderValue(quote.data) }} &euro;</td>
                            <td>{{ quote.created_at.substr(0,10) }}</td>
                        </tr>
                    </table>
                    <!-- <div class="col-md-12" v-if="ordersMore">
                        <button type="button" v-on:click="viewMore('orders')" class="viewMore">View all</button>
                    </div> -->
                </div>
                <div class="col-md-12" v-if="ordersSection">
                    <hr>
                    <h2>Orders</h2>
                    <table class="col-md-12">
                        <thead>
                            <td>#</td>
                            <td>Order status</td>
                            <td>Number of products</td>
                            <td>Total value</td>
                            <td>Date</td>
                        </thead>
                        <tr v-for="(order, index) in orders(client.orders)" v-on:click="openOrder(order.id)">
                            <td>{{ index+1 }}</td>
                            <td>{{ order.status.name }}</td>
                            <td>{{ order.data.length }}</td>
                            <td>{{ countOrderValue(order.data) }} &euro;</td>
                            <td>{{ order.created_at.substr(0,10) }}</td>
                        </tr>
                    </table>
                    <div class="col-md-12" v-if="ordersMore">
                        <button type="button" v-on:click="viewMore('orders')" class="viewMore">View all</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="desa-container">
                <h2>Actions</h2>
                <hr>
                <button class="clientAction active" v-on:click="newOrder()">New order</button>
                <button class="clientAction" v-on:click="newQuote()">New quote</button>
                <button class="clientAction" v-on:click="editClient()">Edit client</button>
                <button class="clientActionDelete" v-on:click="deleteClient()">Delete client</button>
            </div>
        </div>
    </div>
</template>

<script>
import SaleStatistics from './charts/sales.vue';
import RequestStatistics from './charts/requests.vue';

export default{
    components: {
        SaleStatistics,
        RequestStatistics
    },
    data(){
        return{
            client: {
                requests: []
            },
            chartData: [],
            reqStatistics: false,
            activeMore: false,
            historyMore: false,
            orderMore: false,
            ordersSection: false,
            requestSection: false,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/clients/' +this.$route.params.id).then(function(res){
            console.log(res.data);
            app.client = res.data;
            (app.client.orders.length) ? app.ordersSection = true : app.ordersSection = false;
            // (app.client.requests.length) ? app.requestSection = true : app.requestSection = false;
            var index = 0, cd1 = 0, cd2 = 0, cd3 = 0

            // app.client.requests.forEach(res => {
            //     index++;
            //     if(res.request_status.id == 1){
            //         cd1 = cd1+1
            //     } else if(res.request_status.id == 2){
            //         cd2 = cd2+1
            //     } else if(res.request_status.id == 3){
            //         cd3 = cd3+1
            //     }
            //
            //     if(index+1 == app.client.requests.length){
            //         // console.log('done');
            //         app.chartData.push(cd1);
            //         app.chartData.push(cd2);
            //         app.chartData.push(cd3);
            //         app.reqStatistics = true;
            //     }
            //     // console.log(app.reqStatistics);
            // });
        }).catch(function(err){
            toastr.error('Failed to load! ' +err);
            console.log(err);
        })
    },
    methods: {
        requestStatus(el){
            if(el == 1){
                return 'requestInProgress';
            } else if (el == 2){
                return 'requestDone';
            } else if (el == 3){
                return 'requestCanceled';
            }
        },
        editClient(){
            this.$router.push({name:'clientEdit', params: {id:this.$route.params.id}})
        },
        deleteClient(){
            if(confirm('Do you really want to delete it?')){
                var app = this;
                var id = this.$route.params.id;

                event.preventDefault();

                axios.delete('/api/V1/clients/' +id).then(function(res){
                    app.$router.push({name: 'clientIndex'});
                    toastr.success('Client ' + app.client.name + ' deleted!');
                }).catch(function(err){
                    console.log(err);
                    toastr.error('Something wrong, try again.');
                });
            }
        },
        newQuote(){
            var app = this;
            app.$router.push({name: 'quotesCreate', params:{id:app.$route.params.id}});
        },
        newOrder(){
            var app = this;
            app.$router.push({name: 'orderCreateId', params:{id:app.$route.params.id}});
        },
        active(list){
            var temp = [];
            var count = 0;

            for(var i = 0; i < list.length; i++){
                if(list[i].request_status_id == 1 && count < 5) {
                    temp.push(list[i]);
                    count++;
                }
            }
            (count > 4) ? this.activeMore = true : false;

            return temp;
        },
        history(list){
            var temp = [];
            var count = 0;

            for(var i = 0; i < list.length; i++){
                if(list[i].request_status_id != 1 && count < 5) {
                    temp.push(list[i]);
                    count++;
                }
            }

            (count > 4) ? this.historyMore = true : false;
            return temp;
        },
        countOrderValue(list){
            var value = 0;
            list.forEach(el =>{
                value += Number(el.price);
            });
            return value;
        },
        openQuote(id){
            var app = this;

            app.$router.push({name:'quotesView', params:{id:id}});
        },
        orders(list){
            var temp = [];
            var count = 0;

            for(var i = 0; i < list.length; i++){
                if(list[i].request_status_id != 1 && count < 5) {
                    temp.push(list[i]);
                    count++;
                }
            }

            (count > 4) ? this.ordersMore = true : false;
            return temp;
        },
        viewMore(opt){
            var app = this;

            switch(opt){
                case 'history':
                app.$router.push({name:'requestIndex', query:{clientID:this.client.id, action:'history'}});
                break;
                case 'active':
                app.$router.push({name:'requestIndex', query:{clientID:this.client.id, action:'active'}});
                break;
                case 'orders':
                app.$router.push({name:'orderIndex', query:{clientID:this.client.id}});
                break;
            }
        },
        openOrder(id){
            this.$router.push({name:'orderView', params:{id:id}});
        }
    }
}
</script>
