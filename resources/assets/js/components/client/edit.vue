<template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <form v-on:submit="updateClient()">
                <h1>Edit client information</h1>
                <!-- Company info -->
                <div class="col-md-4">
                    <label>Company type</label>
                    <input type="text" class="form-control" v-model="client.company_type" placeholder="UAB" required>
                </div>
                <div class="col-md-4">
                    <label>Company name</label>
                    <input type="text" class="form-control" v-model="client.name" placeholder="Tesla, Inc." required>
                </div>
                <div class="col-md-4">
                    <label>Email</label>
                    <input type="email" class="form-control" v-model="client.email" placeholder="client@example.com">
                </div>
                <div class="col-md-4">
                    <label>Phone number</label>
                    <input type="text" class="form-control" v-model="client.phone" placeholder="+44 xx xxxx xxxx">
                </div>
                <div class="col-md-4">
                    <label>Contact person</label>
                    <input type="text" class="form-control" v-model="client.contact_person" placeholder="John Doe">
                </div>
                <div class="col-md-4">
                    <label>VAT</label>
                    <input type="text" class="form-control" v-model="client.vat" placeholder="LT100006906012">
                    <a href="http://ec.europa.eu/taxation_customs/vies/" target="_blank">Check VAT</a>
                </div>
                <div class="col-md-4">
                    <label>VAT STATUS</label>
                    <select v-model="client.vat_status" class="form-control" required>
                        <option v-bind:value="client.vat_status">{{ client.vat_status }}</option>
                        <option value="EU" v-if="client.vat_status != 'EU'">EU</option>
                        <option value="LT" v-if="client.vat_status != 'LT'">LT</option>
                        <option value="NON EU" v-if="client.vat_status != 'NON EU'">NON EU</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Note</label>
                    <textarea v-model="client.note" rows="2" class="form-control"></textarea>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h2>Delivery & credit</h2>
                </div>
                <div class="col-md-4">
                    <label>Payment term</label>
                    <select v-model="client.payment_term" class="form-control" required v-on:change="creditCheck()">
                        <option value="Advance payment">Advance payment</option>
                        <option value="Payment before delivery">Payment before delivery</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div v-if="credit_status">
                       <label>Credit amount</label>
                       <select v-model="client.credit_amount" class="form-control" required>
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
                <div class="col-md-4">
                    <label>Courier account</label>
                    <input type="text" class="form-control" v-model="client.courier_account" placeholder="DHL">
                </div>
                <div class="col-md-12">
                    <hr>
                    <h2>Address</h2>
                </div>
                <!-- Address -->
                <div class="col-md-3">
                    <label>Street</label>
                    <input type="text" class="form-control" v-model="client.street" placeholder="St. Louise 31">
                </div>
                <div class="col-md-3">
                    <label>Post code</label>
                    <input type="text" class="form-control" v-model="client.post_code" placeholder="9822">
                </div>
                <div class="col-md-3">
                    <label>City</label>
                    <input type="text" class="form-control" v-model="client.city" placeholder="Kansas">
                </div>
                <div class="col-md-3">
                    <label>Country</label>
                    <input type="text" class="form-control" v-model="client.country" placeholder="United states">
                </div>
                <div>
                    <div class="col-md-12">
                        <hr>
                        <h2>Delivery address</h2>
                        <button type="button" class="btn btn-default" v-on:click="copyAddress()">Copy from address</button>
                    </div>
                    <div class="col-md-3">
                        <label>Street</label>
                        <input type="text" class="form-control" v-model="client.delivery_street" placeholder="St. Louise 31">
                    </div>
                    <div class="col-md-3">
                        <label>Post code</label>
                        <input type="text" class="form-control" v-model="client.delivery_post_code" placeholder="9822">
                    </div>
                    <div class="col-md-3">
                        <label>City</label>
                        <input type="text" class="form-control" v-model="client.delivery_city" placeholder="Kansas">
                    </div>
                    <div class="col-md-3">
                        <label>Country</label>
                        <input type="text" class="form-control" v-model="client.delivery_country" placeholder="United states">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="submitButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    window.user_id = '{{ Auth::user()->id }}'
</script>
<script>
export default{
    data(){
        return {
            client: {
                user_id: user_id,
            },
            countries: [],
            credit_status: false,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/clients/' +this.$route.params.id).then(function(res){
            app.client = res.data;
            // console.log(res.data);
            (app.client.payment_term == 'Credit') ? app.credit_status = true : app.credit_status = false;
        }).catch(function(err){
            console.log(err);
        });


    },
    methods:{
         creditCheck(){
            var app = this;
            if (app.client.payment_term == 'Credit'){
               app.credit_status = true
            } else{
               app.credit_status = false
               app.client.credit_amount = ''
            }
         },
         copyAddress(){
             var app = this;
             app.client.delivery_street = app.client.street;
             app.client.delivery_post_code = app.client.post_code;
             app.client.delivery_city = app.client.city;
             app.client.delivery_country = app.client.country;
         },
        updateClient(){
            var app = this;
            var id = this.$route.params.id;

            event.preventDefault();

            axios.patch('/api/V1/clients/' + id, this.client).then(function(res){
                app.$router.push({name: 'clientView', params:{id:id}});
                toastr.success('Client successfully updated!');
            }).catch(function(err){
                console.log('Error' +err);
                toastr.error(err);
            });
        }
    },
}
</script>
