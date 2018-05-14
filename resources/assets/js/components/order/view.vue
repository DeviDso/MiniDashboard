<template>
<div class="desa-full">
<button class="backButton" v-on:click="goBack()">Go back</button>
<div class="desa-container">
    <div class="col-md-12">
        <form id="pdfen" target="print_popup" action="/generate/pdf/quote/english" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
        </form>
        <div class="alert alert-info text-center">
            If you made any changes don't forget to update order data before generating a new PDF
        </div>
    </div>
    <div class="col-md-6">
        <h4>PDF</h4>
        <button type="submite" class="btn btn-primary" onclick="$('#pdfen').submit()">English</button>
        <button type="submite" class="btn btn-primary" onclick="$('#pdfen').submit()">Lietuviškai</button>
    </div>
    <div class="col-md-6 text-right">
        <h4>Actions</h4>
        <button type="button" class="btn btn-danger" v-on:click="deleteOrder(order.id)">Delete order</button>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <form v-on:submit="sendForm()">
        <!-- <h1>New order</h1> -->
        <div class="col-md-12">
            <div class="col-md-5">
                <label>Clientz</label>
                <!-- {{ order }} -->
                <select v-model="order.client_id" class="form-control" disabled>
                    <option v-bind:value="order.client_id">{{ order.client.name }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Order status</label>
                <select v-model="order.status_id" class="form-control" required>
                    <option v-for="status in orderStatus" v-bind:value="status.id">{{ status.name }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Delivery Price</label>
                <input class="form-control" type="number" name="delivery_price" v-model="order.delivery_price" step="0.01" min="0">
            </div>
            <div class="col-md-12">
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
                        <td>Bruto (Kg)</td>
                        <td>Netto (Kg)</td>
                        <td></td>
                    </thead>
                    <tr v-for="product, index in order.data">
                        <td>{{ index+1 }}</td>
                        <td><input type="text" class="form-control" v-model="product.name"></td>
                        <td width="15%"><input type="text" class="form-control" v-model="product.code"></td>
                        <td width="10%"><input type="number" class="form-control" v-model="product.price" step="0.01"></td>
                        <td width="7%"><input type="number" class="form-control" v-model="product.quantity"></td>
                        <td><input type="text" class="form-control" v-model="product.note"></td>
                        <td width="10%"><input type="number" class="form-control" v-model="product.bruto" step="0.01" min="0"></td>
                        <td width="10%"><input type="number" class="form-control" v-model="product.netto" step="0.01" min="0"></td>
                        <td width="5%"><span v-on:click="removeItem(index)">X</span></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <button class="btn btn-info" type="button" v-on:click="newProduct()">+ new product</button>
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
        order: [],
        orderData: {
            user_id: user_id,
            client_id: '',
            delivery_price: '',
            note: '',
            data: [],
            status_id:  1
        },
    }
},
mounted(){
    // this.csrf = window.laravel.csrfToken;
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
        app.orderData.client = order.data.client;

        order.status_id = 1;
    })).catch(function(err){
        toastr.error('Failed to load! ' +err);
    });

},
methods:{
    deleteOrder(id){
        var app = this;

        if(confirm('Do you realy want to delete this order?')){
            axios.delete('/api/V1/orders/' +id).then(function(res){
                app.$router.push({name: 'homeIndex'});
                toastr.success('Order was deleted!');
            }).catch(function(err){
                console.log(err);
                toastr.error('Something wrong, try again.');
            });
        }
    },
    generatePDF(id){
        axios.post('/api/V1/pdf', this.orderData).then(function(res){
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

        this.order.data.push(item)
        // this.productsList.splice(index, 1)
        this.showProducts = true
    },
    addToList(product, index){
        if(!this.order.data.includes(product.code)){
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
        }
        this.searchText = '';
    },
    removeItem(index){
        this.order.data.splice(index, 1);
        (this.order.data.length == 0) ? this.showProducts = false : this.showProducts = true;
    },
    sendForm(){
        event.preventDefault();
        var app = this;

        if(app.order.data.length == 0){
            toastr.error('Do not forget to add products!');
        } else {
            axios.patch('/api/V1/orders/' +app.order.id, app.order).then(function(res){
                toastr.success('order updated!');
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
