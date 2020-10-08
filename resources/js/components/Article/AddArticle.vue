<template>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un Article</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="addPost" enctype="multipart/form-data">
          <div class="form-group" >
        <input type="text" v-model="libelle" class="form-control mb-2" :class="{'jst is-invalid':errors.libelle}" placeholder="Libelle">
        <p class="error-control text-danger" v-if="errors.libelle">
            {{errors.libelle[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="prix" class="form-control mb-2" :class="{'jst is-invalid':errors.prix}" placeholder="Prix">
        <p class="error-control text-danger" v-if="errors.prix">
            {{errors.prix[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="qnt" class="form-control mb-2" :class="{'jst is-invalid':errors.qnt}" placeholder="Quantite">
        <p class="error-control text-danger" v-if="errors.qnt">
            {{errors.qnt[0]}}
         </p>
        </div>
          <div class="form-group">
              <option disabled selected>Catégorie </option>
        <select id="cars" v-model="category" name="category" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.category_id}">
            <option value="">Veuillez choisir une catégorie</option>
            <option :value="category.id" v-for="(category,index) in categories.data" :key="index">
                {{ category.name }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.category_id">
            {{errors.category_id[0]}}
         </p>
          </div>
        
          <div class="form-group">
              <option disabled selected>Marque :</option>
        <select id="cars1" v-model="marque" name="marque" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.marque_id}">
            <option value="">Veuillez choisir une marque</option>
            <option :value="marque.id" v-for="(marque,index) in marques.data" :key="index">
                {{ marque.name }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.marque_id">
            {{errors.marque_id[0]}}
         </p>
          </div>

            <div class="form-group">
              <option disabled selected>Modéle :</option>
        <select id="cars2" v-model="modele" name="modele" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.modele_id}">
            <option value="">Veuillez choisir un Modéle</option>
            <option :value="modele.id" v-for="(modele,index) in modeles.data" :key="index">
                {{ modele.name }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.modele_id">
            {{errors.modele_id[0]}}
         </p>
          </div>

             <div class="form-group">
              <option disabled selected>Fournisseurs :</option>
        <select id="cars2" v-model="fournisseur" name="modele" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.fournisseur_id}">
            <option value="">Veuillez choisir un fournisseur</option>
            <option :value="fournisseur.id" v-for="(fournisseur,index) in fournisseurs.data" :key="index">
                {{ fournisseur.nom }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.fournisseur_id">
            {{errors.fournisseur_id[0]}}
         </p>
          </div>

            <label>Photo :</label>
        <input type="file" v-on:change="onImageChange" class="form-control" name="image" >
        <div  style="margin-top: 22px;">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            libelle : '',
            qnt : '',
            prix : '',
            category : '',
            marque : '',
            fournisseur : '',
            modele : '',
            categories : [],
            fournisseurs : [],
            marques : [],
            modeles : [],
            image : null,
        }
    },
    created(){
                axios.get('/api/category')
                .then(Response=> {
                    this.categories = Response.data;
                    })
                .catch(err=>console.log(err));

                   axios.get('/api/modeles')
                .then(Response=> {
                    this.modeles = Response.data;
                    })
                .catch(err=>console.log(err));

                   axios.get('/api/marques')
                .then(Response=> {
                    this.marques = Response.data;
                    })
                .catch(err=>console.log(err));

                   axios.get('/api/fournisseur')
                .then(Response=> {
                    this.fournisseurs = Response.data;
                    })
                .catch(err=>console.log(err));
            
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
            formData.append("image",this.image);
            formData.append("libelle",this.libelle);
            formData.append("qnt",this.qnt);
            formData.append("prix",this.prix);
            formData.append("category_id",this.category);
            formData.append("marque_id",this.marque);
            formData.append("modele_id",this.modele);
            formData.append("fournisseur_id",this.fournisseur);
            axios.post("api/article",formData,config)
            .then(res => {
                $('#exampleModal').modal('hide');
                this.libelle = '';
                this.qnt = '';
                this.prix = '';
                this.category = '';
                this.marque = '';
                this.modele = '';
                this.fournisseur = '';
                this.image = null;
                          Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Article ajouté',
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