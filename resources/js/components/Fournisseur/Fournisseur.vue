<template>
    <div>
        <add-fourn @added="fournAdded"></add-fourn>
     <div class="card-header mb-3"><h3>Fournisseur</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <button class="btn btn-primary ajoute" style="width: 197px;" data-toggle="modal" data-target="#fournModal"
                 type="button"> <i class="fas fa-plus m-1 "></i>Ajouter Un Fournisseur</button>
            </div>
            <div class="col-md-4 cont-searsh">
                <input type="text" placeholder="Rechercher" class="search rigth" v-model="searchQuery" name="search" id="search"><i class="fas fa-search icSearsh"></i>
            </div>
        </div>
         <div class="col-mx-12">
             
                <div class="card p-4">
             <table class="table">
                 <thead class="thead-dark">
                     <tr>
                         <th class="p-2 text-center" scope="col"><span>Nom</span></th>
                         <th class="p-2 text-center" scope="col"><span>Prénom</span></th>
                         <th class="p-2 text-center" scope="col"><span>Téléphone</span></th>
                         <th class="p-2 text-center" scope="col"><span>Email</span></th>
                         <th class="p-2 text-center" scope="col"><span>Adresse</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>

                     </tr>
                 </thead>
                <thead v-if="resultQuery.length">
                    <tr v-for="(fournisseur,index) in resultQuery" :key="index">
                         
                        <td  class="p-2 text-center" target="_blank">{{fournisseur.nom}}</td>
                        <td  class="p-2 text-center">{{fournisseur.prenom}}</td>
                        <td  class="p-2 text-center"> {{fournisseur.tele}}</td>
                        <td  class="p-2 text-center"> {{fournisseur.Email}}</td>
                        <td  class="p-2 text-center">{{fournisseur.adresse}}</td>
                        <td  class=" text-center ml-2">
                             <router-link  :to="{path : '/fournisseur/details/'+fournisseur.id}">
                          <span class="text-primary m-2" data-toggle="tooltip" data-placement="top" title="Détails" style=" cursor: pointer;">
                                <i class="far fa-eye" ></i>
                             </span>
                        </router-link>
                           <router-link :to="{path : 'fournisseur/edit/'+fournisseur.id}">
                            <span class="text-success m-2" style="cursor: pointer;">
                                <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modifier"></i>
                                </span>
                           </router-link>
                            
                            <a @click="deleteArticle(fournisseur.id)">
                                <span class="text-danger"  style=" cursor: pointer;">
                                <i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Supprimer"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </thead>
                    <tfoot v-else class="tftest">
            <td class="foot"></td>
            <td class="foot"></td>
            <td class="footaucan" style="text-align: end !important;"> Aucun Élément </td>
            <td class="foot"></td>
            <td class="foot"></td>
            <td class="foot"></td>
            </tfoot>
             </table>
             </div>
              <div class="card-footer">
                <pagination :data="fournisseurs" @pagination-change-page="getArticle"></pagination>
             </div>
            </div>
    </div>

</template>
<script>

import AddFourn from './AddFournisseur.vue'
export default {
      data(){
         return{
            fournisseurs:[],
            searchQuery:null
            }
        } ,
        created(){
            this.getArticle();
        },
        components: {AddFourn},
         computed: {
    resultQuery(){
      if(this.searchQuery){
      return this.fournisseurs.data.filter((item)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => item.nom.toLowerCase().includes(v))
      })
      }else{
        return this.fournisseurs.data;
      }
    }
  },
        methods:{
            getArticle(page){
                if(typeof page === undefined){
                    page=1;
                }
                axios.get('/api/fournisseur?page='+page)
                .then(Response=> {
                    this.fournisseurs = Response.data;})
                .catch(err=>console.log(err));
            },
            fournAdded(){
                this.getArticle();
            },
            deleteArticle(id){

     Swal.fire({
                   position: 'center',
                   icon: 'warning',
                   title: 'Êtes-vous sûr',
                   showConfirmButton: true,
                   showCancelButton: true,
                   confirmButtonText:'Oui',
                   confirmButtonColor:'#3085D6',
                   cancelButtonText:'Non',
                   cancelButtonColor:'#d33'
                   }).then(result =>{
                  if(result.value){

                 axios.delete(`/api/fournisseur/${id}`).then(res=>{
                      Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Fournisseur supprimé',
                   showConfirmButton: false,
                   timer: 2500
                  });
                     this.getArticle();
                 }).catch( Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas supprimer ce fournisseur !',
                        }));
                  }
                   })
            }
        }

}
</script>