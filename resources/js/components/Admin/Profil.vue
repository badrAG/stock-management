<template>
<div>
      <div class="card-header mb-3">
        <h5 class="title">Profile</h5>
        </div>
  <div class="row m-2">
    <div class="col-md-12">
    <div class="card p-4">
      <div class="card-body">
          <img :src="image" alt="photo" style="width: 84px;margin-bottom: 19px;" class="rounded shadow-sm img-fluid mr-2">
          <form @submit.prevent="updatePost" enctype="multipart/form-data">
          <div class="form-group">
            <label for="">Nom et Prénom :</label>
        <input type="text" v-model="name" class="form-control mb-3" placeholder="Nom et Prénom">
        </div>
         <div class="form-group">
            <label for="">Email :</label>
        <input type="text" v-model="email" class="form-control mb-3" placeholder="Email">
        </div>
         <div class="form-group">
            <label for="">Mot de passe :</label>
        <input type="password" v-model="password" class="form-control mb-3" placeholder="Mot de passe">
       
        </div>

            <label>Photo :</label>
        <input type="file" v-on:change="onImageChange" class="form-control" name="image" >
        <div class="foot mt-4">
         <button type="button" @click="close()" class="btn btn-secondary">Close</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
        </div>
</form>
      </div> 
       </div>
    </div>
    </div>
  </div>

</template>
<script>
export default {
    data(){
        return{
          errors:{},
           name : "",
            email : '',
            password : '',
            image:'',
            photo: null
           
        }
    },
    created(){
       
            this.getArticle();
    },
    methods:{
        onImageChange(e){
            this.photo=e.target.files[0];
        },
        close(){
            this.$router.push('/dashboard')
        },
        getArticle(){
          axios.get('/api/admin/profile')
          .then(res => {
            console.log(res);
            this.name =  res.data.name;
            this.name =  res.data.name;
            this.email =  res.data.email;
            this.image =  res.data.image;
           
          }).catch(err => console.log(err));
        },
      
        updatePost(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("image",this.photo);
            formData.append("name",this.name);
            formData.append("email",this.email);
            formData.append("password",this.password);
            formData.append("_method","put");
            axios.post(`/api/admin/${8}`,formData,config)
            .then(res => {
                    Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'L\'article a été modifié',
                   showConfirmButton: false,
                   timer: 2500
                  })
                 this.$router.go(0);

            }).catch((error)=>{
              if(error.response.status === 422) {
                this.errors = error.response.data.errors
              }
            })
        }
    }
}
</script>