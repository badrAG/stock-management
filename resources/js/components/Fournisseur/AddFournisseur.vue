<template>
      <div class="modal fade" id="fournModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un Fournisseur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="addFourn" enctype="multipart/form-data">
          <div class="form-group">
        <input type="text" v-model="nom" class="form-control mb-1" :class="{'jst is-invalid':errors.nom}" placeholder="Nom">
           <p class="error-control text-danger" v-if="errors.nom">
            {{errors.nom[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="prenom" class="form-control mb-1" :class="{'jst is-invalid':errors.prenom}" placeholder="Prénom">
        <p class="error-control text-danger" v-if="errors.prenom">
            {{errors.prenom[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="Email" class="form-control mb-1" :class="{'jst is-invalid':errors.Email}" placeholder="Email">
        <p class="error-control text-danger" v-if="errors.Email">
            {{errors.Email[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="tele" class="form-control mb-1" :class="{'jst is-invalid':errors.tele}" placeholder="Téléphone">
        <p class="error-control text-danger" v-if="errors.tele">
            {{errors.tele[0]}}
         </p>
        </div> 
        <div class="form-group">
        <input type="text" v-model="adresse" class="form-control mb-1" :class="{'jst is-invalid':errors.adresse}" placeholder="Adresse">
        <p class="error-control text-danger" v-if="errors.adresse">
            {{errors.adresse[0]}}
         </p>
        </div>
          
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
</form>
      </div>
      <div class="modal-footer">
       
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
            nom : '',
            prenom : '',
            Email : '',
            tele : '',
            adresse : ''
        }
    },
    created(){ },
    methods:{
        addFourn(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("nom",this.nom);
            formData.append("prenom",this.prenom);
            formData.append("Email",this.Email);
            formData.append("tele",this.tele);
            formData.append("adresse",this.adresse);
            axios.post("api/fournisseur",formData,config)
            .then(res => {
                $('#fournModal').modal('hide');
                this.nom = '';
                this.prenom = '';
                this.Email = '';
                this.tele = '';
                this.adresse = '';
                 Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Le Fournisseur a été ajoutée',
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