<template>
    <div>
   
     <div class="card-header mb-3"><h3>Articles</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <button class="btn btn-primary ajoute" data-toggle="modal" data-target="#exampleModal"
                 type="button"> <i class="fas fa-plus m-2 "></i>Ajouter Un Article</button>
            </div>
            <div class="col-md-4 cont-searsh">
                <input type="text" class="search rigth" name="search" id="search"><i class="fas fa-search icSearsh"></i>
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
                         <th class="p-2 text-center" scope="col"><span>Nom Fournisseur</span></th>
                         <th class="p-2 text-center" scope="col"><span>Prénom Fournisseur</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>
                     </tr>
                 </thead>
                <thead>
                    <tr v-for="(command,index) in commands.data" :key="index">
                          <td>
                          <img :src="command.article.photo" alt="photo" style="width: 72px; margin-bottom: 9px" class="rounded">
                          </td>
                             <td  class="p-2 text-center">{{command.article.libelle}}</td>
                             <td  class="p-2 text-center">{{command.article.prix}}</td>
                             <td  class="p-2 text-center">{{command.article.qnt}}</td>
                             <td  class="p-2 text-center"> {{command.fournisseur.nom}}</td>
                             <td  class="p-2 text-center">{{command.fournisseur.prenom}}</td>
                             <td  class="p-2 text-center">
                            <span class="text-primary m-2" style=" cursor: pointer;"><i class="far fa-eye"></i></span>
                           
                            <span class="text-success m-2" data-toggle="modal" data-target="#editarticle" style="cursor: pointer;">
                                <i class="far fa-edit"></i>
                                </span>
                            
                            <a @click="deleteArticle(article.slug)">
                                <span class="text-danger"  style=" cursor: pointer;">
                                <i class="far fa-trash-alt"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </thead>
             </table>
                </div>
            </div>
    </div>

</template>
<script>

export default {
      data(){
         return{
            commands:{}
            }
        } ,
        created(){
            this.getArticle();
        },
        components: {},
        
        methods:{
            getArticle(){
                axios.get('/api/commander')
                .then(Response=> {
                    console.log( Response.data);
                    this.commands = Response.data;})
                .catch(err=>console.log(err));
            },
            articleAdded(){
                this.getArticle();
            },
            deleteArticle(slug){
                 axios.delete(`/api/command/${slug}`).then(res=>{
                     this.getArticle();
                 }).catch(err => console.log(err));
            }
        }

}
</script>