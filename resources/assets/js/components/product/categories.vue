<template>
    <div class="desa-full">
        <div class="desa-container">
            <h1>Categories</h1>
            <h2 v-if="loading">Loading...</h2>
            <table class="col-md-12" v-if="!loading">
                <thead>
                    <td>#</td>
                    <td>Name</td>
                    <td>Products</td>
                    <td>Action</td>
                </thead>
                <tr v-for="(category, index) in paginate(categories)" v-on:click="openCategory(category.id)">
                    <td>{{ index+1 }}</td>
                    <td>{{ category.name }}</td>
                    <td>-</td>
                    <td>-</td>
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
                loading: true,
                products: [],
            }
        },
        mounted(){
            var app = this;

            axios.get('/api/V1/categories').then(function(res){
                app.products = res.data;
                app.loading = false;
            }).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            openCategory(id){
                this.$router.push({name:'productView', params:{id:id}});
            }
        }
    }
</script>
