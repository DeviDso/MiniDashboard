<template>
    <div class="desa-full">
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>Add new product</h1>
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
                        <input type="number" v-model="product.price" class="form-control" min="0.01" step="0.01" value="0.00">
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h4>Product location</h4>
                    </div>
                    <div class="col-md-6">
                        <label>Warehouse</label>
                        <select v-model="product.warehouse" class="form-control" required>
                            <option v-for="warehouse in warehouses" :value="warehouse.id">{{ warehouse.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Location</label>
                        <input type="text" v-model="product.warehouse_location" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h4>Weight</h4>
                    </div>
                    <div class="col-md-6">
                        <label>Bruto (Kg)</label>
                        <input type="number" v-model="product.bruto" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label>Netto (Kg)</label>
                        <input type="number" v-model="product.netto" class="form-control" step="0.01">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Product description</label>
                    <textarea v-model="product.description" class="form-control" rows="5"></textarea>
                    <label>Note</label>
                    <textarea v-model="product.note" class="form-control" rows="5"></textarea>
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
            product: {
                category_id: 1,
                name: '',
                description: '',
                code: '',
                alternative_code: '',
                bruto: '0.00',
                netto: '0.00',
                quantity: 1,
                price: '',
                warehouse_location: '',
                warehouse: 1,
                note: '',
            },
            categories: [],
            warehouses: [],
        }
    },
    mounted(){
        var app = this;

        axios.get('/api/V1/categories').then(function(res){
            app.categories = res.data;
            console.log(res.data);
        }).catch(function(err){
            toastr.error('Failed to load! ' +err);
        });
        axios.get('/api/V1/warehouses').then(function(res){
            app.warehouses = res.data;
            console.log(res.data);
        }).catch(function(err){
            toastr.error('Failed to load! ' +err);
        });
    },
    methods:{
        sendForm(){
            event.preventDefault();

            var app = this;

            axios.post('/api/V1/products', this.product).then(function(res){
                console.log(res);
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
