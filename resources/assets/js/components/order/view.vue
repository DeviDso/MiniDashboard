<template>
<div class="desa-full">
<button class="backButton" v-on:click="goBack()">Go back</button>
<div class="desa-container">
    <div class="col-md-12">
        <h4>Created by: <b>{{ order.user.name }}</b></h4>
    </div>
    <div class="col-md-12">
        <form id="orderEn" target="print_popup" action="/generate/pdf/order/english" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="currency" :value="currency">
        </form>
        <form id="orderLt" target="print_popup" action="/generate/pdf/order/lithuanian" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="currency" :value="currency">
        </form>
        <form id="preInvoiceEn" target="print_popup" action="/generate/pdf/pre-invoice/english" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="currency" :value="currency">
        </form>
        <form id="preInvoiceLt" target="print_popup" action="/generate/pdf/pre-invoice/lithuanian" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="currency" :value="currency">
        </form>
        <form id="invoiceLt" target="print_popup" action="/generate/pdf/invoice/lithuanian" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="currency" :value="currency">
        </form>
        <form id="invoiceEn" target="print_popup" action="/generate/pdf/invoice/english" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
            <input type="hidden" name="quote_id" :value="order.id">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="currency" :value="currency">
        </form>

        <div class="alert alert-info text-center">
            If you made any changes don't forget to update order data before generating a new PDF
        </div>
    </div>
    <div class="col-md-4">
        <h4>PDF</h4>
        Currency:
        <input type="radio" value="EUR" v-model="currency" checked>EUR
        <input type="radio" value="USD" v-model="currency">USD
        <br><br>
        <button type="submite" class="btn btn-primary" onclick="$('#orderEn').submit()">Order</button>
        <button type="submite" class="btn btn-primary" onclick="$('#orderLt').submit()">Order (LT)</button>
        <br><br>
        <button type="submite" class="btn btn-primary" onclick="$('#preInvoiceEn').submit()">Performa invoice</button>
        <button type="submite" class="btn btn-primary" onclick="$('#preInvoiceLt').submit()">Performa invoice (LT)</button>
        <br><br>
        <button type="submite" class="btn btn-primary" onclick="$('#invoiceEn').submit()">Invoice</button>
        <button type="submite" class="btn btn-primary" onclick="$('#invoiceLt').submit()">Invoice (LT)</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Važtaraštis
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Važtaraščio generavimas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form v-on:submit="updateClient()">
              <div class="modal-body">
                  <form id="vaztarastisForm" target="print_popup" action="/generate/pdf/vaztarastis" method="post" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                      <input type="hidden" name="order_id" :value="order.id">
                      <input type="hidden" name="_token" :value="this.csrf">
                      <h3>Vežėjas</h3>
                      <div>
                          <input type="text" name="vezejo_pavadinimas" class="form-control" v-model="vaztarastis.vezejo_pavadinimas = 'UAB \'\'Power Parts Pro\'\''" placeholder="Įmonės pavadinimas">
                      </div>
                      <div>
                          <input type="text" name="vezejo_kodas" class="form-control" v-model="vaztarastis.vezejo_kodas =  '302786671'" placeholder="Įmonės kodas">
                      </div><br>
                      <div>
                          <input type="text" name="vezejo_adresas" class="form-control" v-model="vaztarastis.vezejo_adresas = 'Ateities pl 31, Kaunas' " placeholder="Įmonės adresas">
                      </div>
                      <hr>
                      <h3>Transportas</h3>
                      <div>
                          <input type="text" name="transporto_nr" class="form-control" v-model="vaztarastis.transporto_nr" placeholder="Transporto valstybinis numeris">
                      </div><br>
                      <div>
                          <input type="text" name="transporto_modelis" class="form-control" v-model="vaztarastis.transporto_modelis" placeholder="Transporto modelis">
                      </div>
                      <hr>
                      <h3>Pasikrovimas/Išsikrovimas</h3>
                      <div>
                          <input type="text" name="pakrovimo_vieta" class="form-control" v-model="vaztarastis.parkovimo_vieta" placeholder="Pasikrovimo vieta">
                      </div><br>
                      <div>
                          <input type="text" name="iskrovimo_vieta" class="form-control" v-model="vaztarastis.iskrovimo_vieta" placeholder="Išsikrovimo vieta">
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                <button type="button" class="btn btn-primary" onclick="$('#vaztarastisForm').submit()">Generuoti</button>
              </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-5">
        <label>Note</label>
        <textarea class="form-control" v-model="order.note" rows="3"></textarea>
    </div>
    <div class="col-md-3 text-right">
        <h4>Actions</h4>
        <button type="button" class="btn btn-danger" v-on:click="deleteOrder(order.id)">Delete order</button>
    </div>
    <form v-on:submit="sendForm()">
        <!-- <h1>New order</h1> -->
        <div class="col-md-12">
            <hr>
            <div class="col-md-5">
                <label>Client</label>
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
            <div class="col-md-5">
                <label>Payment term</label>
                <select v-model="order.payment_term" class="form-control" required v-on:change="creditCheck()">
                    <option value="Advance payment">Advance payment</option>
                    <option value="Payment before delivery">Payment before delivery</option>
                    <option value="Credit">Credit</option>
                </select>
            </div>
            <div class="col-md-4">
                <div v-if="credit_status">
                   <label>Credit amount</label>
                   <select v-model="order.credit_term" class="form-control" required>
                       <option :value="5">5 days</option>
                       <option :value="7">7 days</option>
                       <option :value="10">10 days</option>
                       <option :value="14">14 days</option>
                       <option :value="30">30 days</option>
                       <option :value="45">45 days</option>
                       <option :value="90">90 days</option>
                   </select>
                </div>
            </div>
            <div class="col-md-3">
                <label>Courier</label>
                <input type="text" class="form-control" v-model="order.courier" placeholder="DHL">
            </div>
            <div class="col-md-12">
                <hr>
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
                        <td>Bruto (kg)</td>
                        <td>Netto (kg)</td>
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
                <div class="text-right">
                    <b>Total weight</b>: {{ totalWeight }} kg
                </div>
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
        vaztarastis: [],
        csrf: csrf,
        client: [],
        products: [],
        orderStatus: [],
        orderProducts: [],
        searchText: '',
        showResults: false,
        showProducts: true,
        order: [],
        currency: 'EUR',
        credit_status: false,
        orderData: {
            user_id: user_id,
            client_id: '',
            delivery_price: '',
            note: '',
            data: [],
            status_id:  1
        },
        pdfData: {
            _token: this.csrf,
            quote_id: '',
            pdfType: '',
            currency: this.currency
        },
        totalWeight: 0.00,
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
        (app.order.payment_term == 'Credit') ? app.credit_status = true : app.credit_status = false;
        app.countTotalWeight()
    })).catch(function(err){
        toastr.error('Failed to load! ' +err);
    });

},
methods:{
    creditCheck(){
        var app = this;
        if (app.order.payment_term == 'Credit'){
           app.credit_status = true
        } else{
           app.credit_status = false
           app.order.credit_term = ''
        }
    },
    countTotalWeight(){
        console.log("Counting total weight")
        var app = this

        app.totalWeight = parseFloat(0)

        app.order.data.forEach(item => {
            if(item.bruto != null){
                app.totalWeight =  app.totalWeight + (parseFloat(item.bruto) * parseInt(item.quantity))
            }

            console.log(item.bruto)
        })
        app.totalWeight = app.totalWeight.toFixed(2)
    },
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
    // generatePDF(id){
    //     axios.post('/api/V1/pdf', this.orderData).then(function(res){
    //         console.log(res);
    //     }).catch(function(){
    //         console.log(err);
    //     });
    // },
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
    app.countTotalWeight()
    },
    vaztarastis(){
        alert(1);
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
