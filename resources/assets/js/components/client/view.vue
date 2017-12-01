<template>
    <div>
        <div class="col-md-9">
            <div class="desa-container">
                <h1>{{ client.name }}</h1>
                <table class="clientInfo">
                    <tr>
                        <td><i class="fa fa-user"></i></td>
                        <td><i class="fa fa-phone"></i></td>
                        <td><i class="fa fa-envelope"></i></td>
                        <td><i class="fa fa-map-marker"></i></td>
                    </tr>
                    <tr>
                        <td>{{ client.contact_person}}</td>
                        <td>{{ client.phone }}</td>
                        <td>{{ client.email }}</td>
                        <td>{{ client.street + ' ' + client.post_code + ', ' + client.city + ', ' + client.country }}</td>
                    </tr>
                </table>
                <hr>
                <h2>Active orders</h2>
                <hr>
                <h2>Requests</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="desa-container">
                <h2>Actions</h2>
                <hr>
                <button class="clientAction active">New order</button>
                <button class="clientAction" v-on:click="newRequest()">New request</button>
                <button class="clientAction" v-on:click="editClient()">Edit client</button>
                <button class="clientActionDelete" v-on:click="deleteClient()">Delete client</button>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data(){
        return{
            client: []
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/clients/' +this.$route.params.id).then(function(res){
            app.client = res.data;
        }).catch(function(err){
            toastr.error('Failed to load');
        })
    },
    methods: {
        editClient(){
            this.$router.push({name:'clientEdit', params: {id:this.$route.params.id}})
        },
        deleteClient(){
            if(confirm('Do you really want to delete it?')){
                var app = this;
                var id = this.$route.params.id;

                event.preventDefault();

                axios.delete('/api/V1/clients/' +id).then(function(res){
                    app.$router.push({name: 'clientIndex'});
                    toastr.success('Client ' + app.client.name + ' deleted!');
                }).catch(function(err){
                    console.log(err);
                    toastr.error('Something wrong, try again.');
                });
            }
        },
        newRequest(){
            var app = this;
            app.$router.push({name: 'requestCreateId', params:{id:app.$route.params.id}});
        }
    }
}
</script>
