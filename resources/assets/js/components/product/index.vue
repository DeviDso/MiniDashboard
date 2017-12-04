<template>
    <div class="desa-full">
        <div class="desa-container">
            <h1>All products</h1>
            <h2 v-if="loading">Loading...</h2>
            <table class="col-md-12" v-if="!loading">
                <thead>
                    <td>#</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Code</td>
                    <td>Quantity</td>
                    <td>Price</td>
                </thead>
                <tr v-for="product, index in products">
                    <td>{{ index+1 }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.category.name }}</td>
                    <td>{{ product.code }}</td>
                    <td>{{ product.quantity }}</td>
                    <td>{{ product.price }} &euro;</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                loading: true,
                products: []
            }
        },
        mounted(){
            var app = this;

            axios.get('/api/V1/products').then(function(res){
                app.products = res.data;
                app.loading = false;
            }).catch(function(err){
                toastr.error('Failed to load! ' +err);
            });
        }
    }
</script>
