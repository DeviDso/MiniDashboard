<template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <div class="col-md-6">
                <form action="http://powerpartspro.test/generate/pdf" method="post">
                    <input type="hidden" name="quote_id" :value="quote.id">
                    <input type="hidden" name="_token" :value="this.csrf">
                    <button type="submite" class="btn btn-primary">Generate PDF</button>
                </form>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-danger">Delete quote</button>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <form v-on:submit="sendForm()">
                <!-- <h1>New order</h1> -->
                <div class="col-md-8">
                    <div class="col-md-6">
                        <label>Client</label>
                        <!-- {{ quote }} -->
                        <select v-model="quote.client_id" class="form-control" disabled>
                            <option v-bind:value="quote.client_id">{{ quoteData.client.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Delivery Price</label>
                        <input class="form-control" type="number" name="delivery_price" value="0" v-model="quote.delivery_price">
                    </div>
                    <div v-if="showProducts" class="col-md-12">
                        <hr>
                        <label>Products</label>
                        <table class="col-md-12 orderProductTable">
                            <thead>
                                <td>#</td>
                                <td>Product</td>
                                <td>Code</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Note</td>
                                <td></td>
                            </thead>
                            <tr v-for="product, index in quote.data">
                                <td>{{ index+1 }}</td>
                                <!-- <td v-if="product.name != ''">{{ product.name }}</td> -->
                                <td><input type="text" class="form-control" v-model="product.name"></td>
                                <!--  -->
                                <!-- <td v-if="product.code != ''">{{ product.code }}</td> -->
                                <td><input type="text" class="form-control" v-model="product.code"></td>
                                <!--  -->
                                <td><input type="number" class="form-control" v-model="product.price" step="0.01"></td>
                                <td><input type="number" class="form-control" v-model="product.quantity = 1"></td>
                                <td><input type="text" class="form-control" v-model="product.note"></td>
                                <td><span v-on:click="removeItem(index)">X</span></td>
                            </tr>
                        </table>
                    </div>
                    <button class="btn btn-success" type="button" v-on:click="newProduct()">+ new product</button>
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
                csrf: csrf,
                client: [],
                products: [],
                orderStatus: [],
                orderProducts: [],
                searchText: '',
                showResults: false,
                showProducts: true,
                quote: [],
                quoteData: {
                    user_id: user_id,
                    client_id: '',
                    delivery_price: '',
                    note: '',
                    data: [],
                }
            }
        },
        mounted(){
            // this.csrf = window.laravel.csrfToken;
            var app = this;

            axios.all([
                axios.get('/api/V1/quotes/' + app.$route.params.id),
                // axios.get('/api/V1/orderStatus'),
                axios.get('/api/V1/products'),
            ]).then(axios.spread((quote, products) => {
                app.quote = quote.data;
                // app.orderStatus = orderStatus.data;
                app.products = products.data;

                app.quoteData.client_id = quote.data.client_id;
                app.quoteData.client = quote.data.client;

                console.log(app.orderData);
            })).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            generatePDF(id){
                axios.post('/api/V1/pdf', this.quoteData).then(function(res){
                    console.log(res);
                }).catch(function(){
                    console.log(err);
                });
            },
            newProduct(){
                var item = {
                    product_id: '',
                    quantity: 1,
                    name: '',
                    price: 1,
                    code: '',
                }

                this.quote.data.push(item)
                // this.productsList.splice(index, 1)
                this.showProducts = true
            },
            addToList(product, index){
                if(!this.quote.data.includes(product.code)){
                    var item = {
                        product_id: product.id,
                        quantity: product.quantity,
                        name: product.name,
                        price: product.price,
                        code: product.code,
                    }
                    this.quote.data.push(item)
                    this.productsList.splice(index, 1)
                    this.showProducts = true
                }
            },
            removeItem(index){
                this.quote.data.splice(index, 1);
                (this.quote.data.length == 0) ? this.showProducts = false : this.showProducts = true;
            },
            sendForm(){
                event.preventDefault();
                var app = this;

                if(app.quote.data.length == 0){
                    toastr.error('Do not forget to add products!');
                } else {
                    axios.patch('/api/V1/quotes/' +app.quote.id, app.quote).then(function(res){
                        toastr.success('Quote updated!');
                        app.$router.push({name:'clientView',params:{id:app.quote.client_id}})
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
