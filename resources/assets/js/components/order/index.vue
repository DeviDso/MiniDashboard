<template>
    <div class="desa-full">
        <div class="desa-container">
            <table class="col-md-12">
                <thead>
                    <td v-on:click="sortID()">#</td>
                    <td v-on:click="sortClient()">Client</td>
                    <td>Status</td>
                    <td>Date</td>
                </thead>
                <tr v-for="order in paginate(orders)">
                    <td>{{ order.id }}</td>
                    <td>{{ order.client.name }}</td>
                    <td>{{ order.status.name }}</td>
                    <td>{{ order.created_at.substr(0,10) }}</td>
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
    data(){
        return{
            orders: [],
            perPage: 20,
            currentPage: 0,
            resultsCount: 0,
            pageNumber: 1,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/orders').then(function(res){
            app.orders = res.data;
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
        pageResult(pageNumber){
            this.pageNumber = pageNumber;
            this.paginate(this.orders);
        },
        paginate(list){
            this.resultsCount = list.length;

            var index = (this.pageNumber * this.perPage) - 20;

            if(this.pageNumber == 1){
                index = 0;
            }

            return list.slice(index, index + this.perPage);
        },
        sortClient(){
            this.paginate(this.orders.sort((a,b) => {
                if(a.client.name < b.client.name) return -1;
                if(a.client.name > b.client.name) return 1;
                return 0;
            }));
        },
        sortID(){
            this.paginate(this.orders.sort((a,b) => {
                if(a.id < b.id) return -1;
                if(a.id > b.id) return 1;
                return 0;
            }));
        },
    }
}
</script>
