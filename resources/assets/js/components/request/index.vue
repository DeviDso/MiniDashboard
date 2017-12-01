<template>
    <div class="desa-full">
        <div class="desa-container">
            <table class="col-md-12">

            </table>
        </div>
    </div>
</template>

<script>
export default{
    data: function(){
        return {
            request: []
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/requests', {params: { id: user_id}}).then(function(res){
            app.request = res.data;
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
