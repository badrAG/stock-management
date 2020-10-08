<template>
      <div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="addPost" enctype="multipart/form-data">
          <div class="form-group ">
        <input type="text" v-model="name" class="form-control mb-1" :class="{'jst is-invalid':errors.name}" placeholder="Nom">
         <p class="error-control text-danger" v-if="errors.name">
            {{errors.name[0]}}
         </p>
        </div>
          <div class="form-group ">
        <input type="text" v-model="email" class="form-control mb-1" :class="{'jst is-invalid':errors.email}" placeholder="Email">
         <p class="error-control text-danger" v-if="errors.email">
            {{errors.email[0]}}
         </p>
        </div>
          <div class="form-group ">
        <input type="password" v-model="password" class="form-control mb-1" :class="{'jst is-invalid':errors.password}" placeholder="Mot de passe">
         <p class="error-control text-danger" v-if="errors.password">
            {{errors.password[0]}}
         </p>
        </div>
        <div  style="margin-top: 22px;">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
        </div>
</form>
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
            email : '',
            password : '',
        }
    },
    created(){
    },
    methods:{
        onImageChange(e){
            this.image=e.target.files[0];
        },
        addPost(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("name",this.name);
            formData.append("email",this.email);
            formData.append("password",this.password);
            axios.post("api/admin/",formData,config)
            .then(res => {
                $('#addadmin').modal('hide');
                this.name = '';
                this.email = '';
                this.password = '';
                this.image = null;
                          Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Admin ajouté',
                   showConfirmButton: false,
                   timer: 2500
                  })
                this.$emit('added');
            }).catch((error)=>{
              if(error.response.status === 422) {
                this.errors = error.response.data.errors
              }
            })
        }
    }
}
</script>