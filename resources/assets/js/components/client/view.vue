<template>
    <div>
        <div class="col-md-9">
            <div class="desa-container">
                <h1>{{ client.name }}</h1>
                <hr>
                <table class="clientInfo">
                    <tr>
                        <td><i class="fa fa-user"></i> {{ client.contact_person}}</td>
                        <td><i class="fa fa-phone"></i>{{ client.phone }}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope"></i>{{ client.email }}</td>
                        <td><i class="fa fa-map-marker"></i>{{ client.street + ' ' + client.post_code + ', ' + client.city + ', ' + client.country }}</td>
                    </tr>
                </table>
                <hr>
                <h2>Requests</h2>
                <div class="col-md-6">
                    <h3>Active</h3>
                    <table class="col-md-12">
                        <thead>
                            <td>Request</td>
                            <td>Date</td>
                        </thead>
                        <tr v-for="(request, index) in active(client.requests)">
                            <td>{{ request.request_type.name }}</td>
                            <td>{{ request.created_at.substr(0, 10) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>History</h3>
                    <table class="col-md-12">
                        <thead>
                            <td>Request</td>
                            <td>Date</td>
                            <td>Status</td>
                        </thead>
                        <tr v-for="(request, index) in history(client.requests)">
                            <td>{{ request.request_type.name }}</td>
                            <td>{{ request.created_at.substr(0, 10) }}</td>
                            <td> {{request.request_status.name}}</td>
                        </tr>
                    </table>
                </div>  
                <div class="col-md-12">
                    <hr>
                    <h2>Orders</h2>
                </div>
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
            loop: 0,
            client: {
                requests: []
            },
            activeRequestCount: 0,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/clients/' +this.$route.params.id).then(function(res){
            app.client = res.data;
            console.log(res.data);
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
        },
        active(list){
            var temp = [];
            var count = 0;

            for(var i = 0; i < list.length; i++){
                if(list[i].request_status_id == 1 && count < 5) {
                    temp.push(list[i]);
                    count++;
                }
            }
            return temp;
        },
        history(list){
            var temp = [];
            var count = 0;

            for(var i = 0; i < list.length; i++){
                if(list[i].request_status_id == 2,3 && count < 5) {
                    temp.push(list[i]);
                    count++;
                }
            }
            return temp;
        }
    }
}
</script>
