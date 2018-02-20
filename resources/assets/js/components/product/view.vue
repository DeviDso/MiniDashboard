<template>
    <div class="desa-full">
        <button class="backButton" v-on:click="goBack()">Go back</button>
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>{{product.name}}</h1>
                <div class="col-md-6">
                    <label>Product name</label>
                    <input type="text" v-model="product.name" class="form-control" required>
                    <label>Category</label>
                    <select v-model="product.category_id" class="form-control" required>
                        <option v-for="category in categories" v-bind:value="category.id">{{ category.name }}</option>
                    </select>
                    <div class="col-md-6">
                        <label>Code</label>
                        <input type="text" v-model="product.code" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Alternative code</label>
                        <input type="text" v-model="product.alternative_code" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Quantity</label>
                        <input type="number" v-model="product.quantity" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Price (&euro;)</label>
                        <input type="number" v-model="product.price" class="form-control" min="1" step="any">
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h4>Weight</h4>
                    </div>
                    <div class="col-md-6">
                        <label>Bruto</label>
                        <input type="number" v-model="product.bruto" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Netto</label>
                        <input type="number" v-model="product.netto" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Product description</label>
                    <textarea v-model="product.description" class="form-control" rows="5"></textarea>
                </div>
                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="submitButton">Update</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default{
    data(){
        return {
            product: {
                category_id: '',
                name: '',
                description: '',
                code: '',
                alternative_code: '',
                bruto: '',
                netto: '',
                quantity: 1,
                price: ''
            },
            categories: [],
        }
    },
    mounted(){
        var app = this;
        axios.all([
            axios.get('/api/V1/products/' + this.$route.params.id),
            axios.get('/api/V1/categories')
        ]).then(axios.spread((product, categories) =>{
            this.product = product.data;
            this.categories = categories.data;
        })).catch(function(err){
            toastr.error('Failed to load! ' +err);
        });


    },
    methods:{
        sendForm(){
            event.preventDefault();

            var app = this;

            axios.patch('/api/V1/products/' +this.$route.params.id, this.product).then(function(res){
                toastr.success('Product created!');
                app.$router.push({name: 'productIndex'});
            }).catch(function(err){
                console.log(err);
                toastr.error('Failed to create! ' + err);
            });
        }
    }
}
</script>
