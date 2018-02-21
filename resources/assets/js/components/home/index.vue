<template>
    <div>
        <div class="col-md-12">
            <div class="desa-container" v-if="showTotalSales">
                <h2>Sales this year</h2>
                <total-sales :labels="labels" :data="sales" />
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="desa-container" v-if="showTotalRequests">
                <h2>Total requests</h2>
                <total-requests :data="totalRequests" />
            </div>
        </div> -->
        <div class="col-md-12">
            <div class="desa-container" v-if="employeeStatistics" id="employeeStatistics">
                <h2>Employees Statistics</h2>
                <table>
                    <thead>
                        <td>Name</td>
                        <td>Orders</td>
                        <td>Sales</td>
                    </thead>
                    <tr v-for="item in sortedSales">
                        <td>{{ item.name }}</td>
                        <td>{{ item.orders }}</td>
                        <td>{{ item.sales }} &euro;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import TotalSales from './charts/sales.vue';
    import TotalRequests from './charts/requests.vue';

    var moment = require('moment');
    export default{
        components:{
            TotalSales,
            TotalRequests,
        },
        computed:{
            sortedSales(){
                // console.log('sorting');
                return this.userSales.sort((a,b) => {
                    if(a.sales > b.sales) return -1;
                    if(a.sales < b.sales) return 1;
                    return 0;
                });
            }
        },
        data(){
            return{
                orders: [],
                requests: [],
                showTotalSales: false,
                showTotalRequests: false,
                labels: moment.monthsShort(),
                sales: [],
                totalRequests: [],
                users: [],
                userSales: [],
                employeeStatistics: false,
            }
        },
        mounted(){
            var app = this;
            // console.log(app.dates);

            axios.all([
                axios.get('/api/V1/orders'),
                axios.get('/api/V1/requests'),
                axios.get('/api/V1/users'),
            ]).then(axios.spread((orders, requests, users) => {
                app.orders = orders.data;
                app.requests = requests.data;
                app.users = users.data;

                app.totalSales();
                app.TotalRequests();
                app.countSales();
            })).catch(err => {
                console.log(err);
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            countSales(){
                var app = this;

                app.users.forEach(user =>{
                    var name = user.name;
                    var orders = user.order.length;
                    var sales = 0;
                    user.order.forEach(order =>{
                        order.data.forEach(data =>{
                            sales = sales + data.price;
                        });
                    });
                    app.userSales.push({name, orders, sales});

                    app.employeeStatistics = true;
                });
            },
            TotalRequests(){
                var app = this;

                var req1 = 0, req2 = 0, req3 = 0;

                app.requests.forEach(res => {
                    if(res.request_status_id == 1){
                        req1 = req1 + 1;
                    } else if(res.request_status_id == 2){
                        req2 = req2 + 1;
                    } else if(res.request_status_id == 3){
                        req3 = req3 + 1;
                    }
                });
                app.totalRequests.push(req1, req2, req3);
                app.showTotalRequests = true;
            },
            totalSales(){
                var app = this;

                var Jan = 0,Feb = 0,Mar = 0,Apr = 0,May = 0,Jun = 0,Jul = 0,Aug = 0,Sep = 0,Oct = 0,Nov = 0,Dec = 0;
                var totalSales = 0;

                var start = moment().startOf('year').format('YYYY-MM-DD');
                var now = moment().format('YYYY-MM-DD');

                var months = moment.monthsShort();

                app.orders.forEach(res => {
                    res.data.forEach(data => {
                        totalSales = totalSales + data.price;

                        var date = moment(data.created_at, 'YYYY-MM-DD');
                        var month = moment(data.created_at).month();

                        if(date.isBetween(start, now)) {
                            switch(month){
                                case 0:
                                Jan = Jan + data.price
                                break;
                                case 1:
                                Feb = Feb + data.price
                                break;
                                case 2:
                                Mar = Mar + data.price
                                break;
                                case 3:
                                Apr = Apr + data.price
                                break;
                                case 4:
                                May = May + data.price
                                break;
                                case 5:
                                Jun = Jun + data.price
                                break;
                                case 6:
                                Jul = Jul + data.price
                                break;
                                case 7:
                                Aug = Aug + data.price
                                break;
                                case 8:
                                Sep = Sep + data.price
                                break;
                                case 9:
                                Oct = Oct + data.price
                                break;
                                case 10:
                                Nov = Nov + data.price
                                break;
                                case 11:
                                Dec = Dec + data.price
                                break;
                            }
                        }
                    })

                });
                app.sales.push(Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec);

                // console.log(app.sales);

                app.showTotalSales = true;
            }
        },
    }
</script>
