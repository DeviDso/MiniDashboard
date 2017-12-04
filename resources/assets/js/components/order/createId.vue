<template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>New order</h1>
                <div class="col-md-8">
                    <div class="col-md-6">
                        <label>Client</label>
                        <select v-model="order.client_id" class="form-control" required>
                            <option v-bind:value="client.id" selected="selected">{{ client.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Order status</label>
                        <select v-model="order.status_id" class="form-control" required>
                            <option v-for="status in orderStatus" v-bind:value="status.id">{{ status.name }}</option>
                        </select>
                    </div>
                    <div v-if="showProducts">
                        <label>Products</label>
                        <table class="col-md-12 orderProductTable">
                            <thead>
                                <td>Product</td>
                                <td>Code</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td></td>
                            </thead>
                            <tr v-for="product, index in orderProducts">
                                <td>{{ product.name }}</td>
                                <td>{{ product.code }}</td>
                                <td><input type="number" v-model="product.price"></td>
                                <td><input type="number" v-model="product.quantity = 1"></td>
                                <td><span v-on:click="removeItem(index)">X</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Product search</label>
                    <input type="search" class="form-control" v-model="searchText" placeholder="Search product by code">
                    <div class="orderProducts">
                        <ul v-if="showResults">
                            <li v-for="product, index in productsList"  v-on:click="addToList(product, index)">
                                {{ product.name.substr(0, 25) }} <b>{{ product.code }}</b>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="submitButton">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                client: [],
                products: [],
                orderStatus: [],
                orderProducts: [],
                searchText: '',
                showResults: false,
                showProducts: false,
                order: {
                    user_id: user_id,
                    client_id: '',
                    status_id: '',
                },
                orderData: []
            }
        },
        mounted(){
            var app = this;

            axios.all([
                axios.get('/api/V1/clients/' + this.$route.params.id),
                axios.get('/api/V1/orderStatus'),
                axios.get('/api/V1/products'),
            ]).then(axios.spread((client, orderStatus, products) => {
                app.client = client.data;
                app.order.client_id = client.data.id;
                app.orderStatus = orderStatus.data;
                app.products = products.data;
            })).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            addToList(product, index){
                if(!this.orderProducts.includes(product.code)){
                    this.orderProducts.push(product)
                    this.productsList.splice(index, 1)
                    this.showProducts = true
                }
            },
            removeItem(index){
                this.orderProducts.splice(index, 1);
                (this.orderProducts.length == 0) ? this.showProducts = false : this.showProducts = true;
            },
            sendForm(){
                event.preventDefault();
                var app = this;

                if(app.orderProducts.length == 0){
                    toastr.error('Do not forget to add products!');
                } else {
                    axios.post('/api/V1/orders', app.order).then(function(res){
                        console.log(res);
                        for(var i = 0; i < app.orderProducts.length; i++){
                            app.orderData.push({
                                order_id: res.data.id,
                                product_id: app.orderProducts[i].id,
                                quantity: app.orderProducts[i].quantity,
                            });
                        }
                        axios.post('/api/V1/orderData', app.orderData).then(function(res){
                            toastr.success('Order was created!');
                            app.$router.push({name:'clientView', params:{id:this.$route.params.id}});
                        }).catch(function(err){
                            console.log(err);
                        });
                    console.log(app.orderData);
                    }).catch(function(err){
                        toastr.error('Failed to save data! ' +err);
                        console.log(err);
                    });
                }
            }
        },
        computed:{
            productsList(){
                this.showResults = true;
                return this.products.filter(product => {
                    return product.code.includes(this.searchText);
                });
            }
        },
        watch:{
            searchText(){
                (this.searchText != '')? this.showResults = true : this.showResults = false;
            }
        }
    }
</script>
