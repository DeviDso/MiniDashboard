<template>
    <div class="desa-full">
        <div v-if="clientRequests">
            <button class="backButton" v-on:click="goBack()">Go back</button>
        </div>
        <div class="desa-container">
            <div v-if="loading">
                <h2>Loading...</h2>
            </div>
            <table class="col-md-12" v-if="!loading">
                <thead>
                    <td>Company</td>
                    <td>Request type</td>
                    <td>Request status</td>
                    <td>Request date</td>
                </thead>
                <tr v-for="req, index in paginate(requests)" v-on:click="openRequest(req.id)">
                    <td>{{ req.client.name }}</td>
                    <td>{{ req.request_type.name }}</td>
                    <td v-bind:class="requestStatus(req.request_status.id)">{{ req.request_status.name }}</td>
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
            requests: [],
            loading: true,
            clientRequests: false,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/requests', {params: { id: user_id}}).then(function(res){
            app.requests = res.data;
            if(app.$route.query.clientID && app.$route.query.action == 'active'){
                app.requests = app.requests.filter(req => req.client_id == app.$route.query.clientID && req.request_status_id == 1)
                app.clientRequests = true;
            }
            if(app.$route.query.clientID && app.$route.query.action == 'history'){
                app.requests = app.requests.filter(req => req.client_id == app.$route.query.clientID && req.request_status_id != 1)
                app.clientRequests = true;
            }
            app.loading = false;
            // console.log(res.data);
        }).catch(function(err){
            toastr.error('Failed to load');
        });
    },
    methods:{
        openRequest(id){
            this.$router.push({name: 'requestView', params: {id:id}})
        },
        requestStatus(el){
            if(el == 1){
                return 'requestInProgress';
            } else if (el == 2){
                return 'requestDone';
            } else if (el == 3){
                return 'requestCanceled';
            }
        },
    }
}
</script>
