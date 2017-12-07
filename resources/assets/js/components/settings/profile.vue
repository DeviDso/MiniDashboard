<template>
    <div class="col-md-12">
        <div class="desa-container">
            <form v-on:submit="sendForm()">
                <h1>Profile settings</h1>
                <hr>
                <div class="col-md-3">
                    <label>Profile photo</label>
                    <br>
                    <img :src="user.photo" :alt="user.name" style="max-width: 100%;max-height: 225px">
                    <br>
                    <input type="file" @change="uploadPhoto($event)" name="photo" ref="fileInput">
                    <!-- <input id="my_file" type="file" @change="fileChanged($event)" ref="fileInput"> -->
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control" v-model="user.email" disabled>
                    <label>First name</label>
                    <input type="text" class="form-control" v-model="user.name">
                    <label>Last name</label>
                    <input type="text" class="form-control" v-model="user.surname">
                    <label>Phone number</label>
                    <input type="text" class="form-control" v-model="user.phone">
                </div>
                <div class="col-md-12">
                    <h2>Change password</h2>
                    <hr>
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label>Current password</label>
                        <input type="password" class="form-control">
                        <label>New password</label>
                        <input type="password" class="form-control">
                        <label>Repeat password</label>
                        <input type="password" class="form-control">
                    </div>
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
                user: []
            }
        },
        mounted(){
            var app = this;

            axios.get('/api/V1/users/' +user_id).then(res => {
                // console.log(res.data);
                app.user = res.data;
            }).catch(err => {
                console.log(err);
                toastr.error('Failed to load! ' +err);
            });
        },
        methods:{
            sendForm(){
                event.preventDefault();

                var app = this;

                axios.patch('/api/V1/users/' +user_id, app.user).then(res => {
                    toastr.success('Profiled updated!');
                }).catch(err => {
                    console.log(err);
                    toastr.error('Failed to save! ' +err);
                });
            },
            uploadPhoto(e){
                var app = this;

                var reader = new FileReader();
                var formData = new FormData();

                reader.onload = (e) => {
                    this.user.photo = e.target.result;
                }

                formData.append('photo', event.target.files[0]);
                formData.append('user_id', user_id);

                axios.post('/api/V1/users', formData).then(res =>{
                    console.log(res);
                    if(res.data.error){
                        toastr.error(res.data.error);
                    }else{
                        reader.readAsDataURL(e.target.files[0]);
                        app.user.photo = res.data;
                        toastr.success('Profile picture updated!');
                    }
                }).catch(err => {
                    console.log(err);
                    toastr.error('Failed to load! ' +err);
                });
            }
        }
    }
</script>
