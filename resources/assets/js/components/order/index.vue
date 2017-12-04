<template>
    <div class="desa-full">
        <div class="desa-container">
            <table class="col-md-12">
                <thead>
                    <td>#</td>
                    <td>Client</td>
                    <td>Status</td>
                    <td>Date</td>
                </thead>
                <tr v-for="order, index in paginate(orders)">
                    <td>{{ index+1 }}</td>
                    <td>{{ order.client.name }}</td>
                    <td>{{ order.status.name }}</td>
                    <td>{{ order.created_at.substr(0,10) }}</td>
                </tr>
            </table>
            <div class="col-md-12">
                <ul class="pagination">
                  <li v-for="page, index in totalPages" v-if="Math.abs(page - currentPage) < 3 || page == totalPages - 1 || page == 0"><a v-on:click="setPage(index)">{{ index+1 }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    data(){
        return{
            orders: [],
            perPage: 5,
            currentPage: 0,
            resultsCount: 0,
            //totalPages: 0,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/orders').then(function(res){
            app.orders = res.data;
            app.totalPages = Math.ceil(app.resultsCount/app.perPage);
            console.log(res.data);
        }).catch(function(err){
            toastr.error('Failed to load! ' +err.data);
        });
    },
    computed: {
        totalPages(){
            return Math.ceil(this.resultsCount/this.perPage);
        }
    },
    methods:{
        paginate(list){
            this.resultsCount = list.length;

            var index = this.currentPage * this.perPage;

            return list.slice(index, index + this.perPage);
        },
        setPage(page){
            this.currentPage = page;
        }
    }
}
</script>
