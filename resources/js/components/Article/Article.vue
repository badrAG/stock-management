<template>
    <div>
        <AddArticle @added="articleAdded"></AddArticle>
     <div class="card-header mb-3"><h3>Articles</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <button class="btn btn-primary ajoute" data-toggle="modal" data-target="#exampleModal"
                 type="button"> <i class="fas fa-plus m-2 "></i>Ajouter Un Article</button>
            </div>
            <div class="col-md-4 cont-searsh">
                <input type="search"  class="search rigth" v-model="searchQuery" placeholder="Rechercher" name="search" id="search"><i class="fas fa-search icSearsh"></i>
            </div>
        </div>
         <div class="col-md-12">
             
                <div class="card p-4">
             <table class="dv-table">
                 <thead class="thead-dark">
                     <tr>
                         <th class="p-2 " scope="col"><span>Image</span></th>
                         <th class="p-2 text-center" scope="col"><span>Libelle</span></th>
                         <th class="p-2 text-center" scope="col"><span>Prix</span></th>
                         <th class="p-2 text-center" scope="col"><span>Quantite</span></th>
                         <th class="p-2 text-center" scope="col"><span>Catégorie</span></th>
                         <th class="p-2 text-center" scope="col"><span>Marque</span></th>
                         <th class="p-2 text-center" scope="col"><span>Modéle</span></th>
                         <th class="p-2 text-center" scope="col"><span>Fournisseur</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>
                     </tr>
                 </thead>
                <thead v-if="resultQuery.length">
                    <tr v-for="(article,index) in resultQuery" :key="index">
                          <td scope="row">
                          <img :src="article.photo" alt="photo" style="width: 72px; margin-bottom: 9px" class="rounded">
                          </td>
                        <td scope="row" class="p-2 text-center" target="_blank">{{article.libelle}}</td>
                        <td scope="row" class="p-2 text-center">{{article.prix}} DH</td>

                        <td scope="row" v-if="article.qnt <= 0" class="p-2 text-center"><span class="badge badge-danger p-1">Terminé</span></td>
                        <td scope="row" v-if="article.qnt < 11 && article.qnt >0" class="p-2 text-center"><span class="badge badge-warning p-1">{{article.qnt}}</span></td>
                        <td scope="row" v-if="article.qnt > 10" class="p-2 text-center"><span class="badge badge-success p-1">{{article.qnt}}</span></td>

                        <td scope="row" class="p-2 text-center"> {{article.category.name}}</td>
                        <td scope="row" class="p-2 text-center">{{article.marque.name}}</td>
                        <td scope="row" class="p-2 text-center">{{article.modele.name}}</td>
                        <td scope="row" class="p-2 text-center">{{article.fournisseur.nom}}</td>
                        <td scope="row" class="p-2 text-center">
                           <router-link :to="{path : 'article/edit/'+article.slug}">
                            <span class="text-success m-2" style="cursor: pointer;">
                                <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modifier"></i>
                                </span>
                           </router-link>
                            <a @click="deleteArticle(article.slug)">
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
            <td class="foot"></td>
            <td class="foot"></td>
            <td class="footaucan"> Aucun Élément </td>
            <td class="foot"></td>
            <td class="foot"></td>
            <td class="foot"></td>
            <td class="foot"></td>
            </tfoot>
             </table>
                </div>
                <div class="card-footer">
                <pagination :data="articles" @pagination-change-page="getArticle"></pagination>
             </div>
            </div>
    </div>

</template>
<script>
import AddArticle from './AddArticle';
export default {
      data(){
         return{
             searchQuery: null,
            articles:[]
            }
        } ,
        created(){
            this.getArticle();
        },
          computed: {
    resultQuery(){
      if(this.searchQuery){
      return this.articles.data.filter((item)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => item.libelle.toLowerCase().includes(v))
      })
      }else{
        return this.articles.data;
      }
    }
  },
   components: {AddArticle},
        methods:{
            getArticle(page){
                  if( typeof page===undefined){
                    page=1;
                }
                axios.get('/api/article?page='+page)
                .then(Response=> {
                    console.log(Response.data)
                    this.articles = Response.data;
                    })
                .catch(err=>console.log(err));
            },
            articleAdded(){
                this.getArticle();
            }, 
            deleteArticle(slug){
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

                 axios.delete(`/api/article/${slug}`).then(res=>{
                      Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Article supprimé',
                   showConfirmButton: false,
                   timer: 2500
                  });
                     this.getArticle();
                 }).catch( Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas supprimer ce produit car il peut y avoir des demandes!',
                        }));
                  }
                   })
            }
        },
 
   

}
</script>