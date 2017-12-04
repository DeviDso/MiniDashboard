<template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>New request</h1>
                <!-- Request -->
                <div class="col-md-4">
                    <label>Company</label>
                    <select class="form-control" v-model="request.client_id">
                        <option v-bind:value="client.id" select="selected" disabled>{{ client.name }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Request type</label>
                    <select class="form-control" v-model="request.request_type_id" required>
                        <option v-for="request, index in request_type" v-bind:value="request.id">{{ request.name }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Request Status</label>
                    <select class="form-control" v-model="request.request_status_id" required>
                        <option v-for="status, index in request_status" v-bind:value="status.id">{{ status.name }}</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label>Note</label>
                    <textarea class="form-control" v-model="request.note"></textarea>
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
            request: {
                user_id: user_id,
                client_id: '',
                request_type_id: '',
                request_status_id: '',
                note: '',
            },
            client: [],
            request_status: [],
            request_type: [],
        }
    },
    mounted(){
        var app = this;

        axios.all([
            axios.get('/api/V1/clients/' + this.$route.params.id),
            axios.get('/api/V1/requestType'),
            axios.get('/api/V1/requestStatus')
        ]).then(axios.spread((client, requestType, requestStatus) => {
            app.client = client.data;
            app.request_status = requestStatus.data;
            app.request_type = requestType.data;

            app.request.client_id = client.data.id;
        }));
    },
    methods:{
        sendForm(){
            var app = this;
            event.preventDefault();

            axios.post('/api/V1/requests', this.request).then(function(res){
                app.$router.push({name: 'clientView', params:{id:app.$route.params.id}});
                toastr.success('New request successfully added!');
            }).catch(function(err){
                console.log('Error' +err.data);
                toastr.error(err);
            });
        }
    }
}
</script>
