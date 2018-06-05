<template>
    <div class="desa-full">
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>New order</h1>
                <div class="col-md-8">
                    <div class="col-md-6">
                        <label>Client</label>
                        <select v-model="order.client_id" class="form-control" required>
                            <option v-for="client in clients" v-bind:value="client.id">{{ client.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Order status</label>
                        <select v-model="order.status_id" class="form-control" required>
                            <option v-for="status in orderStatus" v-bind:value="status.id">{{ status.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Delivery price (&euro;)</label>
                        <input class="form-control" type="number" name="delivery_price" v-model="order.delivery_price" step="0.01" min="0">
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
                    <h4>Products</h4>
                    <div v-if="showProducts">
                        <table class="col-md-12 orderProductTable">
                            <thead>
                                <td>#</td>
                                <td>Product</td>
                                <td>Code</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Note</td>
                                <td>Unit w.</td>
                                <td>Total w.</td>
                                <td></td>
                            </thead>
                            <tr v-for="product, index in order.data">
                                <td>{{ index+1 }}</td>
                                <td><input type="text" class="form-control" v-model="product.name"></td>
                                <td width="15%"><input type="text" class="form-control" v-model="product.code"></td>
                                <td width="10%"><input type="number" class="form-control" v-model="product.price" step="0.01"></td>
                                <td width="7%"><input type="number" class="form-control" v-model="product.quantity = 1"></td>
                                <td><input type="text" class="form-control" v-model="product.note"></td>
                                <td width="10%"><input type="number" class="form-control" v-model="product.bruto" step="0.01" min="0"></td>
                                <td width="10%"><input type="number" class="form-control" v-model="product.netto" step="0.01" min="0"></td>
                                <td width="5%"><span v-on:click="removeItem(index)">X</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <button class="btn btn-success" type="button" v-on:click="newProduct()">+ new product</button>
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
            var today = new Date().toJSON().slice(0,10).replace(/-/g,'/');
            return{
                clients: [],
                order: {
                    user_id: user_id,
                    client_id: '',
                    delivery_price: '',
                    data: [],
                },
                searchText: '',
                showResults: false,
                showProducts: false,
                clients: [],
                products: [],
                orderData: [],
                orderProducts: [],
            }
        },
        mounted(){
            var app = this;

            axios.all([
                axios.get('/api/V1/clients'),
                axios.get('/api/V1/orderStatus'),
                axios.get('/api/V1/products'),
            ]).then(axios.spread((clients, orderStatus, products) => {
                app.clients = clients.data;
                app.orderStatus = orderStatus.data;
                app.products = products.data;
            })).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            newProduct(){
                var item = {
                    product_id: '',
                    quantity: 1,
                    name: '',
                    price: 1,
                    code: '',
                }

                this.order.data.push(item)
                // this.productsList.splice(index, 1)
                this.showProducts = true
            },
            addToList(product, index){
                if(!this.order.data.includes(product.code)){
                    console.log(product);
                    var item = {
                        product_id: product.id,
                        quantity: product.quantity,
                        name: product.name,
                        price: product.price,
                        code: product.code,
                    }
                    this.order.data.push(item)
                    this.productsList.splice(index, 1)
                    this.showProducts = true

                    this.searchText = '';
                }
            },
            removeItem(index){
                this.order.data.splice(index, 1);
                (this.order.data.length == 0) ? this.showProducts = false : this.showProducts = true;
            },
            sendForm(){
                event.preventDefault();
                var app = this;

                console.log(app.order);
                // return true;

                if(app.order.data.length == 0){
                    toastr.error('Do not forget to add products!');
                } else {
                    axios.post('/api/V1/orders', app.order).then(function(res){
                        toastr.success('Order created!');
                        app.$router.push({name:'clientView', params:{id:app.order.client_id}})
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
