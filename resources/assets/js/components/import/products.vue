<template>
    <div class="col-md-12">
        <div class="desa-container">
          <h1>Products import</h1>
          <hr>
          <form @submit.prevent="syncProducts">
            <label for="">Please select products file (.csv)</label>
            <input type="file" id="csv_file" value="">
            <hr>
            <button type="submit" name="button" class="btn btn-primary">Import</button>
          </form>
        </div>
    </div>
</template>

<script>
  export default{
    data(){
      return{
        uploadData: []
      }
    },
    methods:{
      syncProducts(){
        var formData = new FormData();
        var csvFile = document.querySelector('#csv_file')
        formData.append("csv_file", csvFile.files[0])
        axios.post('import/products', formData, {headers: {
      'Content-Type': 'multipart/form-data'
    }}).then(res =>{
      this.$router.push({name: 'home', params:{}});
      toastr.success('Products imported successfully!');
        }).catch(err => {
            console.log(err)
        });
      }
    }
  }
</script>
