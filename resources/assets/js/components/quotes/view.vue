        <template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <div class="col-md-12">
                <h4>Created by: <b>{{ quote.user.name }}</b></h4>
                <hr>
            </div>
            <div class="col-md-6">
                <button type="submite" class="btn btn-success" v-on:click="createOrder()">Convert into order</button>
                <form id="pdfen" target="print_popup" action="/generate/pdf/quote/english" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                    <input type="hidden" name="quote_id" :value="quote.id">
                    <input type="hidden" name="_token" :value="this.csrf">
                    <input type="hidden" name="currency" :value="currency">
                </form>
                <form id="pdflt" target="print_popup" action="/generate/pdf/quote/lithuanian" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                    <input type="hidden" name="quote_id" :value="quote.id">
                    <input type="hidden" name="_token" :value="this.csrf">
                    <input type="hidden" name="currency" :value="currency">
                </form>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-danger" v-on:click="deleteQuote(quote.id)">Delete quote</button>
            </div>
            <div class="col-md-12">
                <hr>
                <h4>PDF</h4>
                Currency:
                <input type="radio" value="EUR" v-model="currency" checked>EUR
                <input type="radio" value="USD" v-model="currency">USD
                <br><br>
            </div>
            <div class="col-md-12">
                <button type="submite" class="btn btn-primary" onclick="$('#pdfen').submit()">English</button>
                <button type="submite" class="btn btn-primary" onclick="$('#pdflt').submit()">Lietuviškai</button>
                <hr>
            </div>
            <form v-on:submit="sendForm()">
                <!-- <h1>New order</h1> -->
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>Client</label>
                        <!-- {{ quote }} -->
                        <select v-model="quote.client_id" class="form-control" disabled>
                            <option v-bind:value="quote.client_id">{{ quoteData.client.name }}</option>
                        </select>
                        <label>Delivery Price</label>
                        <input class="form-control" type="number" name="delivery_price" v-model="quote.delivery_price" step="0.01" min="0">
                        <!-- <label>Order status</label>
                        <select v-model="quote.status_id" class="form-control" required>
                            <option v-for="status in orderStatus" v-bind:value="status.id">{{ status.name }}</option>
                        </select> -->
                    </div>
                    <div class="col-md-6">
                        <label>Note</label>
                        <textarea class="form-control" v-model="quote.note" rows="5"></textarea>
                    </div>
                    <div class="col-md-12">
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
                                <td>Bruto (kg)</td>
                                <td>Netto (kg)</td>
                                <td></td>
                            </thead>
                            <tr v-for="product, index in quote.data">
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
                        <hr>
                        <div class="text-right">
                            <b>Total weight</b>: {{ totalWeight }} kg
                        </div>
                    </div>
                    <div class="col-md-12">
                       <button class="btn btn-info" type="button" v-on:click="newProduct()">+ new product</button>
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
                currency: 'EUR',
                quote: [],
                totalWeight: 0.00,
                quoteData: {
                    user_id: user_id,
                    client_id: '',
                    delivery_price: '',
                    note: '',
                    data: [],
                },
                order: {
                    order_id: this.$route.params.id,
                    client_id: '',
                    user_id: user_id,
                }
            }
        },
        mounted(){
            // this.csrf = window.laravel.csrfToken;
            var app = this;

            axios.all([
                axios.get('/api/V1/quotes/' + app.$route.params.id),
                axios.get('/api/V1/orderStatus'),
                axios.get('/api/V1/products'),
                // axios.get('/api/V1/orderStatus'),
            ]).then(axios.spread((quote, status, products) => {
                app.quote = quote.data;
                app.orderStatus = status.data;
                app.products = products.data;

                app.quoteData.client_id = quote.data.client_id;
                app.order.client_id = quote.data.client_id;
                app.quoteData.client = quote.data.client;
                app.countTotalWeight()
                // console.log(app.orderData);
            })).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            countTotalWeight(){
                console.log("Counting total weight")
                var app = this

                app.totalWeight = parseFloat(0)

                app.quote.data.forEach(item => {
                    if(item.bruto != null){
                        app.totalWeight =  app.totalWeight + parseFloat(item.bruto)
                    }

                    console.log(item.bruto)
                })
                app.totalWeight = app.totalWeight.toFixed(2)
            },
            createOrder(){
                var app = this;

                axios.post('/api/V1/orders', app.quote).then(function(res){
                    app.$router.push({name:'orderView', params:{id:app.order.order_id}})
                    toastr.success('Order from quote successfully created!');
                }).catch(function(err){
                    console.log(err);
                });
            },
            deleteQuote(id){
                var app = this;

                if(confirm('Do you realy want to delete this quote?')){
                    axios.delete('/api/V1/quotes/' +id).then(function(res){
                        app.$router.push({name: 'homeIndex'});
                        toastr.success('Quote was deleted!');
                    }).catch(function(err){
                        console.log(err);
                        toastr.error('Something wrong, try again.');
                    });
                }
            },
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
                this.searchText = '';
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
                        // app.$router.push({name:'clientView',params:{id:app.quote.client_id}})
                    }).catch(function(err){
                        toastr.error('Failed to save data! ' +err);
                        console.log(err);
                    });
                }
                app.countTotalWeight()
            }
        },
        computed:{
            productsList(){
                this.showResults = true;

                var temp = [];

                this.products.forEach((item) => {
                    if(temp.length == 10) return temp;
                    (item.name.toLowerCase().includes(this.searchText)) ? temp.push(item) : false;
                    (item.code.toLowerCase().includes(this.searchText)) ? temp.push(item) : false;
                });

                return temp;
                // return this.products.filter(product => {
                //     return product.code.includes(this.searchText);
                // });
            }
        },
        watch:{
            searchText(){
                (this.searchText != '')? this.showResults = true : this.showResults = false;
            }
        }
    }
</script>
<style media="screen">
    input[type="radio"]{
        margin-left: 7px;
        margin-right: 3px;
    }
</style>
