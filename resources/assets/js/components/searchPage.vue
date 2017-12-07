<template>
    <div class="col-md-12">
        <div class="desa-container">
            <h1 v-if="!searchText">Search</h1>
            <h1 v-if="searchText">Searching for '{{searchText}}'</h1>
            <hr>
            <h2 v-if="showResults">No results...</h2>
            <div class="col-md-4">
                <h2>Clients</h2>
                <table class="col-md-12">
                    <tr v-for="client in filterClients(clients, searchText)" v-on:click="openClient(client.id)">
                        <td>{{ client.name }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <h2>Products</h2>
                <table class="col-md-12">
                    <tr v-for="product in filterProducts(products, searchText)" v-on:click="openProduct(product.id)">
                        <td>{{ product.name }} ({{product.code}})</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                showResults: false,
                clients: [],
                requests: [],
                orders: [],
                products: [],
            }
        },
        mounted(){
            var app = this;

            axios.all([
                axios.get('/api/V1/clients'),
                axios.get('/api/V1/products'),
                // axios.get('/api/V1/requests'),
                // axios.get('/api/V1/orders')
            ]).then(axios.spread((clients, products) => {
                app.clients = clients.data;
                // app.requests = requests.data;
                // app.orders = orders.data;
                app.products = products.data;
            })).catch(err => {
                console.log(err);
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            filterClients(list, text){
                var temp = [];

                list.forEach(item => {
                    if(temp.length == 10) return temp;
                    (item.name.toLowerCase().includes(text)) ? temp.push(item) : false;
                });

                return temp;
            },
            filterProducts(list, text){
                var temp = [];

                list.forEach((item) => {
                    if(temp.length == 10) return temp;
                    (item.name.toLowerCase().includes(text)) ? temp.push(item) : false;
                });

                return temp;
            },
            openClient(id){
                this.$router.push({name:'clientView', params:{id:id}});
            },
            openProduct(id){
                this.$router.push({name:'productView', params:{id:id}});
            }
        },
        computed:{
            searchText(){
                return this.$route.query.q;
            },
        },
        watch:{
            searchText(){
                // console.log('Changed!');
            }
        }
    }
</script>
