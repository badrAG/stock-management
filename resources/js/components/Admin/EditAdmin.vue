<template>
<div>
      <div class="card-header mb-3">
        <h5 class="title">Modifier admin</h5>
        </div>
  <div class="row m-2">
    <div class="col-md-12">
    <div class="card p-4">
      <div class="card-body">
          <form @submit.prevent="updateFourn" enctype="multipart/form-data">
          <div class="form-group">
        <input type="text" v-model="name" class="form-control mb-1" :class="{'jst is-invalid':errors.name}" placeholder="Nom">
        <p class="error-control text-danger" v-if="errors.name">
            {{errors.name[0]}}
         </p>
        </div>
         <div class="form-group">
        <input type="text" v-model="Email" class="form-control mb-1" :class="{'jst is-invalid':errors.Email}" placeholder="Email">
        <p class="error-control text-danger" v-if="errors.Email">
            {{errors.Email[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="password" v-model="password" class="form-control mb-1" :class="{'jst is-invalid':errors.password}" placeholder="Mot de passe">
        <p class="error-control text-danger" v-if="errors.password">
            {{errors.password[0]}}
         </p>
        </div>
         
         <button type="button" @click="close()" class="btn btn-secondary">Close</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
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
            name : '',
            password : '',
            Email : '',
        }
    },
    created(){
            this.getArticle();
    },
    methods:{
        close(){
         this.$router.push('/admin')
        },
        getArticle(){
          axios.get(`/api/admins/${this.$route.params.id}`)
          .then(res => {
            console.log(res.data);
            this.name =  res.data.name;
            this.prenom =  res.data.password;
            this.Email =  res.data.Email;
          }).catch(err => console.log(err));
        },
        
        updateFourn(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("name",this.name);
            formData.append("Email",this.Email);
            formData.append("password",this.password);
            formData.append("_method","put");
            axios.post(`/api/admins/${this.$route.params.id}`,formData,config)
            .then(res => {
                this.name = '';
                this.Email = '';
                this.password = '';
                Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Admin a été modifié',
                   showConfirmButton: false,
                   timer: 2500
                  })
                  this.$router.push('/admin')
            }).catch((error)=>{
              if(error.response.status === 422) {
                this.errors = error.response.data.errors
              }
            })
        }
    }
}
</script>