<template>
    <div class="desa-full">
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>New quote</h1>
                <!-- Request -->
                <div class="col-md-5">
                    <label>Company</label>
                    <select class="form-control" v-model="quote.client_id">
                        <option v-for="client, index in clients" v-bind:value="client.id">{{ client.name }}</option>
                    </select>

                    <label>Delivery price (&euro;)</label>
                    <input class="form-control" type="number" name="delivery_price" v-model="quote.delivery_price" step="0.01" min="0">
                </div>
                <div class="col-md-7">
                    <label>Note</label>
                    <textarea class="form-control" v-model="quote.note" rows="4"></textarea>
                </div>
                <div class="col-md-12">
                    <!-- <br> -->
                    <hr>
                    <label>Product search</label>
                    <input type="search" class="form-control" v-model="searchText" placeholder="Search product by code">
                    <div class="orderProducts">
                        <ul v-if="showResults">
                            <div v-if="productsList.length == 0">
                                Product is not in a warehouse, you can add it manualy!
                                <br>
                                <button class="btn btn-success" type="button" v-on:click="newProduct()">+ new product</button>
                            </div>
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
        return {
            quote: {
                user_id: user_id,
                client_id: this.$route.params.id,
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
            axios.get('/api/V1/products')
        ]).then(axios.spread((clients, products) => {
            app.clients = clients.data;
            app.products = products.data;
        }));
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

            this.quote.data.push(item)
            // this.productsList.splice(index, 1)
            this.showProducts = true
        },
        sendForm(){
            var app = this;
            event.preventDefault();

            axios.post('/api/V1/quotes', this.quote).then(function(res){
                app.$router.push({name: 'quotesIndex'});
                toastr.success('New quote successfully added!');
            }).catch(function(err){
                console.log('Error' +err);
                toastr.error(err);
            });
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
