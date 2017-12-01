<template>
    <div class="desa-full">
        <div class="desa-container">
            <form v-on:submit="updateClient()">
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
                name: '',
                phone: '',
                email: '',
                contact_person: '',
                street: '',
                city: '',
                post_code: '',
                country: ''
            },
            countries: []
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/clients/' +this.$route.params.id).then(function(res){
            app.client = res.data;
            console.log(res.data);
        }).catch(function(err){
            console.log(err);
        });
    },
    methods:{
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
    }
}
</script>
