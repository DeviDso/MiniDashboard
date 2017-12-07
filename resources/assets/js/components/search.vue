<template>
    <div>
        <form v-on:submit="search()">
            <div class="col-md-11">
                <input ref="searchBar" type="search" v-model="searchText" class="form-control" placeholder="Search for clients, orders, products...">
            </div>
            <div class="col-md-1">
                <button type="submit" class="submitButton">Search</button>
            </div>
        </form>
        <!-- <div ref="searchResults" class="searchResults" v-if="searchResults"> -->

        <!-- </div> -->
    </div>
</template>
<script>
    export default{
        data(){
            return {
                searchText: '',
                searchResults: false,
            }
        },
        mounted(){

        },
        methods:{
            search(){
                event.preventDefault();

                var app = this;
                app.$router.push({name:'search', query:{q:app.searchText}});
            }
        },
        watch:{
            searchText(){
                var app = this;
                app.$router.push({name:'search', query:{q:app.searchText}});
            }
        }
    }
</script>
