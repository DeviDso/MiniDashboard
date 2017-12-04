<template>
    <div class="desa-full">
        <div class="desa-container">
            <table class="col-md-12">
                <thead>
                    <td>Company</td>
                    <td>Request type</td>
                    <td>Request status</td>
                    <td>Request date</td>
                </thead>
                <tr v-for="req, index in paginate(requests)" v-on:click="openRequest(req.id)">
                    <td>{{ req.client.name }}</td>
                    <td>{{ req.request_type.name }}</td>
                    <td>{{ req.request_status.name }}</td>
                    <td>{{ req.created_at }}</td>
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
            requests: []
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/requests', {params: { id: user_id}}).then(function(res){
            app.requests = res.data;
            console.log(res.data);
        }).catch(function(err){
            toastr.error('Failed to load');
        });
    },
    methods:{
        openRequest(id){
            this.$router.push({name: 'requestView', params: {id:id}})
        }
    }
}
</script>
