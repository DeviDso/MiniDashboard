<template>
    <div class="desa-full">
        <div class="desa-container">
            <table class="col-md-12">
                <thead>
                    <td>Company</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Contact person</td>
                    <td>Address</td>
                </thead>
                <tr v-for="client, index in paginate(clients)" v-on:click="openClient(client.id)">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.contact_person }}</td>
                    <td>{{ client.street + ' ' + client.post_code + ', ' + client.city + ', ' + client.country }}</td>
                </tr>
            </table>
            <div class="col-md-12">
                <paginate
                  :page-count="totalPages"
                  :click-handler="pageResult"
                  :prev-text="'Prev'"
                  :next-text="'Next'"
                  :container-class="'pagination'">
                </paginate>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data: function(){
        return {
            clients: [],
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/clients').then(function(res){
            app.clients = res.data;
            console.log(res.data);
        }).catch(function(err){
            toastr.error('Failed to load');
        });
    },
    methods:{
        openClient(id){
            this.$router.push({name: 'clientView', params: {id:id}})
        }
    }
}
</script>
