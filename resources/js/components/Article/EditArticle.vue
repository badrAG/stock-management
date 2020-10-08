<template>
<div>
      <div class="card-header mb-3">
        <h5 class="title">Modifier cet Article</h5>
        </div>
  <div class="row m-2">
    <div class="col-md-12">
    <div class="card p-4">
      <div class="card-body">
            <img :src="photo" alt="photo" style="width: 102px; margin-bottom: 11px" class="rounded">
          <form @submit.prevent="updatePost" enctype="multipart/form-data">
          <div class="form-group">
            <label for="">Libelle :</label>
        <input type="text" v-model="libelle" class="form-control mb-1"  :class="{'jst is-invalid':errors.libelle}" placeholder="Libelle">
        <p class="error-control text-danger" v-if="errors.libelle">
            {{errors.libelle[0]}}
         </p>
        </div>
          <div class="form-group">
            <label for="">Prix :</label>
        <input type="text" v-model="prix" class="form-control mb-1" :class="{'jst is-invalid':errors.prix}" placeholder="Prix">
        <p class="error-control text-danger" v-if="errors.prix">
            {{errors.prix[0]}}
         </p>
        </div>
          <div class="form-group">
            <label for="">Quantité :</label>
        <input type="text" v-model="qnt" class="form-control mb-1" :class="{'jst is-invalid':errors.qnt}" placeholder="Quantite">
        <p class="error-control text-danger" v-if="errors.qnt">
            {{errors.qnt[0]}}
         </p>
        </div>
          <div class="form-group">
              <option disabled selected>Veuillez choisir une  Catégorie :</option>
        <select id="cars" v-model="category" name="category" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.category_id}" >
            <option :value="category.id" v-for="(category,index) in categories.data" :key="index">
                {{ category.name }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.category_id">
            {{errors.category_id[0]}}
         </p>
          </div>
        
          <div class="form-group">
              <option disabled selected>Veuillez choisir une  marque :</option>
        <select id="cars1" v-model="marque" name="marque" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.marque_id}" >
            <option :value="marque.id" v-for="(marque,index) in marques.data" :key="index">
                {{ marque.name }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.marque_id">
            {{errors.marque_id[0]}}
         </p>
          </div>

            <div class="form-group">
              <option disabled selected>Veuillez choisir une  modéle :</option>
        <select id="cars2" v-model="modele" name="modele" value='cdcdcdc' class="form-control mb-1 combo"  :class="{'jst is-invalid':errors.modele_id}" >
            <option :value="modele.id" v-for="(modele,index) in modeles.data" :key="index">
                {{ modele.name }}
            </option>
        </select>
        <p class="error-control text-danger" v-if="errors.modele_id">
            {{errors.modele_id[0]}}
         </p>
          </div>

 <div class="form-group">
              <option disabled selected>Veuillez choisir une fournisseur :</option>
        <select id="cars" v-model="fournisseur" name="category" class="form-control mb-1 combo"  :class="{'jst is-invalid':errors.fournisseur_id}" >
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
           libelle : '',
            qnt : '',
            statut : '',
            prix : '',
            category : '',
            marque : '',
            photo : '',
            modele : '',
            fournisseur : '',
            fournisseurs : [],
            categories : [],
            marques : [],
            modeles : [],
            image : null,
        }
    },
    created(){
                axios.get('/api/category')
                .then(Response=> {
                    this.categories = Response.data;
                  console.log(this.categories);

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
            this.getArticle();
    },
    methods:{
        onImageChange(e){
            this.image=e.target.files[0];
        },
        close(){
            this.$router.push('/article')
        },
        getArticle(){
          axios.get(`/api/article/${this.$route.params.slug}`)
          .then(res => {
            console.log(res.data);
            this.libelle =  res.data.libelle;
            this.prix =  res.data.prix;
            this.qnt =  res.data.qnt;
            this.category =  res.data.category;
            this.modele =  res.data.modele;
            this.marque =  res.data.marque;
            this.fournisseur =  res.data.fournisseur;
            this.photo =  res.data.photo;
          }).catch(err => console.log(err));
        },
        
        updatePost(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("image",this.image);
            formData.append("libelle",this.libelle);
            formData.append("qnt",this.qnt);
            formData.append("prix",this.prix);
            formData.append("marque_id",this.marque);
            formData.append("category_id",this.category);
            formData.append("modele_id",this.modele);
            formData.append("fournisseur_id",this.fournisseur);
            formData.append("_method","put");
            axios.post(`/api/article/${this.$route.params.slug}`,formData,config)
            .then(res => {
                this.libelle = '';
                this.qnt = '';
                this.prix = '';
                this.fournisseur = '';
                this.category = '';
                this.marque = '';
                this.modele = '';
                this.image = null;
                    Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'L\'article a été modifié',
                   showConfirmButton: false,
                   timer: 2500
                  })
                  this.$router.push('/article')
            }).catch((error)=>{
              if(error.response.status === 422) {
                this.errors = error.response.data.errors
              }
            })
        }
    }
}
</script>