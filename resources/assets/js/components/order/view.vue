<template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <!-- <h1>New order</h1> -->
                <div class="col-md-8">
                    <div class="col-md-6">
                        <label>Client</label>
                        <select v-model="orderData.client_id" class="form-control" disabled>
                            <option v-bind:value="orderData.client_id">{{ orderData.client.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Order status</label>
                        <select v-model="orderData.status_id" class="form-control" required>
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
                            <tr v-for="item, index in orderData.data">
                                <td>{{ item.name }}</td>
                                <td>{{ item.code }}</td>
                                <td><input type="number" v-model="item.price" step="0.01"></td>
                                <td><input type="number" v-model="item.quantity"></td>
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
                    <button type="submit" class="submitButton">Update</button>
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
                showProducts: true,
                order: [],
                orderData: {
                    user_id: user_id,
                    client_id: '',
                    status_id: '',
                    client: [],
                    status: [],
                    data: [],
                }
            }
        },
        mounted(){
            var app = this;

            axios.all([
                axios.get('/api/V1/orders/' + app.$route.params.id),
                axios.get('/api/V1/orderStatus'),
                axios.get('/api/V1/products'),
            ]).then(axios.spread((order, orderStatus, products) => {
                app.order = order.data;
                app.orderStatus = orderStatus.data;
                app.products = products.data;

                app.orderData.client_id = order.data.client_id;
                app.orderData.status_id = order.data.status_id;
                app.orderData.client = order.data.client;
                app.orderData.status = order.data.status;

                order.data.data.forEach(res =>{
                    var item = {
                        product_id: res.product_id,
                        quantity: res.quantity,
                        name: res.product.name,
                        price: res.price,
                        code: res.product.code,
                    }
                    app.orderData.data.push(item);
                })

                console.log(app.orderData);
            })).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            addToList(product, index){
                if(!this.orderData.data.includes(product.code)){
                    var item = {
                        product_id: product.id,
                        quantity: product.quantity,
                        name: product.name,
                        price: product.price,
                        code: product.code,
                    }
                    this.orderData.data.push(item)
                    this.productsList.splice(index, 1)
                    this.showProducts = true
                }
            },
            removeItem(index){
                this.orderData.data.splice(index, 1);
                (this.orderData.data.length == 0) ? this.showProducts = false : this.showProducts = true;
            },
            sendForm(){
                event.preventDefault();
                var app = this;

                if(app.orderData.data.length == 0){
                    toastr.error('Do not forget to add products!');
                } else {
                    axios.patch('/api/V1/orders/' +app.order.id, app.orderData).then(function(res){
                        toastr.success('Order updated!');
                        app.$router.push({name:'clientView',params:{id:app.orderData.client_id}})
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
