<template>
    <div class="desa-full">
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>Add new company</h1>
                <!-- Company info -->
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
                    <label>Note</label>
                    <textarea v-model="client.note" rows="2" class="form-control"></textarea>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h2>Delivery & credit</h2>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <label>Payment term</label>
                    <select v-model="client.payment_term" class="form-control" required>
                        <option value="Advance payment">Advance payment</option>
                        <option value="Payment before delivery">Payment before delivery</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Courier account</label>
                    <input type="text" class="form-control" v-model="client.courier_account" placeholder="DHL">
                </div>
                <div class="col-md-12">
                    <hr>
                    <h2>Address</h2>
                </div>
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
                    <button type="submit" class="submitButton">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default{
    data(){
        return {
            client: {
                name: '',
                phone: '',
                email: '',
                contact_person: '',
                street: '',
                city: '',
                post_code: '',
                country: '',
                credit_amount: 5,
                payment_term: 'advance',
            },
            countries: [],
            delivery: true,
        }
    },
    mounted(){
        var app = this;
    },
    methods:{
        sendForm(){
            var app = this;
            event.preventDefault();

            axios.post('/api/V1/clients', this.client).then(function(res){
                app.$router.push({path: '/'});
                toastr.success('New client successfully added!');
            }).catch(function(err){
                console.log('Error' +err);
                toastr.error(err);
            });
        }
    }
}
</script>
