<template>
    <div class="desa-full">
        <div v-if="clientOrders">
            <button class="backButton" v-on:click="goBack()">Go back</button>
        </div>
        <div class="desa-container">
            <table class="col-md-12">
                <thead>
                    <td v-on:click="sortID()">#</td>
                    <td v-on:click="sortClient()">Client</td>
                    <td>Products</td>
                    <td>Delivery price</td>
                    <td>User</td>
                    <td>Date</td>
                </thead>
                <tr v-for="quote in paginate(quotes)" v-on:click="openQuote(quote.id)">
                    <td>{{ quote.id }}</td>
                    <td>{{ quote.client.name }}</td>
                    <td>{{ quote.data.length }}</td>
                    <td>{{ quote.delivery_price }} &euro;</td>
                    <td>{{ quote.user.name }}</td>
                    <td>{{ quote.created_at.substr(0,10) }}</td>
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
            quotes: [],
            perPage: 20,
            currentPage: 0,
            resultsCount: 0,
            pageNumber: 1,
            clientOrders: false,
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/quotes').then(function(res){
            app.quotes = res.data;
            console.log(res.data);
            if(app.$route.query.clientID){
                app.quotes = app.quotes.filter(res => res.client_id == app.$route.query.clientID);
                app.clientOrders = true;
            }
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
            this.paginate(this.quotes.sort((a,b) => {
                if(a.client.name < b.client.name) return -1;
                if(a.client.name > b.client.name) return 1;
                return 0;
            }));
        },
        sortID(){
            this.paginate(this.quotes.sort((a,b) => {
                if(a.id < b.id) return -1;
                if(a.id > b.id) return 1;
                return 0;
            }));
        },
        openQuote(id){
            this.$router.push({name: 'quotesView', params:{id:id}});
        }
    }
}
</script>
