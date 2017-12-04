<template>
    <div class="desa-full">
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>Client request</h1>
                <!-- Request -->
                <div class="col-md-4">
                    <label>Company</label>
                    <select class="form-control" v-model="request.client_id">
                        <option v-bind:value="request.client_id" disabled>{{ request.client.name }}</option>
                        <!-- <option v-for="client, index in clients" :value="client.id" :slected="client.id == request.client_id">{{ client.name }} {{request.client_id}}</option> -->
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Request type</label>
                    <select class="form-control" v-model="request.request_type_id">
                        <option v-for="request, index in request_type" v-bind:value="request.id">{{ request.name }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Request Status</label>
                    <select class="form-control" v-model="request.request_status_id">
                        <option v-for="status, index in request_status" v-bind:value="status.id">{{ status.name }}</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label>Note</label>
                    <textarea class="form-control" v-model="request.note"></textarea>
                </div>
                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="submitButton">Update</button>
                    <button type="button" class="deleteButton" v-on:click="deleteRequest()">Delete</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default{
    data(){
        return {
            request: {
                client: [],

            },
            request_status: [],
            request_type: [],
        }
    },
    mounted(){
        var app = this;
        console.log(this.$route.params.id);
        axios.all([
            axios.get('/api/V1/requests/' + this.$route.params.id, {params:{id:user_id}}),
            axios.get('/api/V1/requestType'),
            axios.get('/api/V1/requestStatus')
        ]).then(axios.spread((request, requestType, requestStatus) => {
            app.request = request.data;
            app.request_status = requestStatus.data;
            app.request_type = requestType.data;

            console.log(app.request);
        }));
    },
    methods:{
        sendForm(){
            var app = this;
            event.preventDefault();

            axios.patch('/api/V1/requests/' +this.$route.params.id, this.request).then(function(res){
                app.$router.push({name: 'requestIndex'});
                toastr.success('Request successfully updated!');
            }).catch(function(err){
                console.log('Error' +err);
                toastr.error(err);
            });
        },
        deleteRequest(){
            if(confirm("Do you realy want to delete it?")) {
                var app = this;

                axios.delete('/api/V1/requests/' +this.$route.params.id, {params:{id:user_id}}).then(function(res){
                    app.$router.push({name: 'requestIndex'});
                    toastr.success('Request deleted!');
                }).catch(function(err){
                    toastr.error('Something wrong ' +err);
                })
            }
        }
    }
}
</script>
