<template>
<div>
      <div class="card-header mb-3">
        <h5 class="title">Modifier Fournisseur</h5>
        </div>
  <div class="row m-2">
    <div class="col-md-12">
    <div class="card p-4">
      <div class="card-body">
          <form @submit.prevent="updateFourn" enctype="multipart/form-data">
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
            nom : '',
            prenom : '',
            tele : '',
            Email : '',
            adresse : '',
        }
    },
    created(){
            this.getArticle();
    },
    methods:{
        close(){
         this.$router.push('/fournisseur')
        },
        getArticle(){
          axios.get(`/api/fournisseur/${this.$route.params.id}`)
          .then(res => {
            console.log(res.data);
            this.nom =  res.data.nom;
            this.prenom =  res.data.prenom;
            this.tele =  res.data.tele;
            this.Email =  res.data.Email;
            this.adresse =  res.data.adresse;
         
          }).catch(err => console.log(err));
        },
        
        updateFourn(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("nom",this.nom);
            formData.append("prenom",this.prenom);
            formData.append("tele",this.tele);
            formData.append("Email",this.Email);
            formData.append("adresse",this.adresse);
            formData.append("_method","put");
            axios.post(`/api/fournisseur/${this.$route.params.id}`,formData,config)
            .then(res => {
                this.nom = '';
                this.prenom = '';
                this.tele = '';
                this.Email = '';
                this.adresse = '';
                Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Le Fournisseur a été modifié',
                   showConfirmButton: false,
                   timer: 2500
                  })
                  this.$router.push('/fournisseur')
            }).catch((error)=>{
              if(error.response.status === 422) {
                this.errors = error.response.data.errors
              }
            })
        }
    }
}
</script>