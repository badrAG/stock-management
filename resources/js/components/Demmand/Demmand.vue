<template>
    <div>
     <div class="card-header mb-3"><h3>Demmandes</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <router-link :to="addDemmande">
                <button class="btn btn-primary ajoute"
                 type="button"> <i class="fas fa-plus m-2 "></i>Ajouter un Demmande</button>
                 </router-link>
            </div>
            <div class="col-md-4 cont-searsh">
                <input type="search"  class="search rigth" name="search" id="search"><i class="fas fa-search icSearsh"></i>
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
                         <th class="p-2 text-center" scope="col"><span>Statut</span></th>
                         <th class="p-2 text-center" scope="col"><span>Category</span></th>
                         <th class="p-2 text-center" scope="col"><span>Marque</span></th>
                         <th class="p-2 text-center" scope="col"><span>Modele</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>
                     </tr>
                 </thead>
                <thead>
                  
                      
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
             addDemmande:'/demmande/add',
             demands:{}
            }
        } ,
        created(){
        this.getArticle();
        },
        components: {},
        
        methods:{
            getArticle(){
                axios.get('/api/demande')
                .then(Response=> {
                    console.log(Response.data.demmande);
                    this.demands = Response.data;})
                .catch(err=>console.log(err));
            },
        }
 
   

}
</script>