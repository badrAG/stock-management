<template>
    <div>
     <div class="card-header mb-3"><h3> détails de service </h3></div>
        <div class="row m-2">
            <div class="col-md-8">
            <h3> <span class="badge badge-secondary bdgtitle">{{count_agents}} agents dans le service {{ name }} </span></h3>
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
                     </tr>
                 </thead>
                <thead v-if="agents.length" >
                    <tr v-for="(agent,index) in resultQuery" :key="index">
                          <td scope="row">
                          <img :src="agent.photo" alt="photo" style="width: 72px; margin-bottom: 9px" class="rounded">
                          </td>
                        <td  class="p-2 text-center" target="_blank">{{agent.libelle}}</td>
                        <td  class="p-2 text-center">{{agent.prix}}</td>
                        <td  class="p-2 text-center"> {{agent.qnt}}</td>
                        <td  class="p-2 text-center"> {{agent.category}}</td>
                        <td  class="p-2 text-center"> {{agent.marque}}</td>
                        <td  class="p-2 text-center"> {{agent.fournisseur}}</td>
                    </tr>
                </thead>
                   <tfoot v-else class="tftest">
            <td class="foot"></td>
            <td class="foot"></td>
            <td class="footaucan"> Aucun Élément </td>
            <td class="foot"></td>
            </tfoot> 
             </table>
             </div>
            </div>
    </div>

</template>
<script>

export default {
      data(){
         return{
            agents:{},
            count_agents:'',
            name:'',
            searchQuery:null
            }
        } ,
        created(){
            this.editserv();
        },
        components: {},
         computed: {
    resultQuery(){
      if(this.searchQuery){
      return this.agents.filter((item)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => item.nom.toLowerCase().includes(v))
      })
      }else{
        return this.agents;
      }
    }
  },
        methods:{
               editserv(id){
                 axios.get(`/api/modeles/${this.$route.params.id}`)
          .then(res => {
            console.log(res.data);
            this.agents =  res.data.agents;
            this.count_agents =  res.data.agent_count;
            this.name =  res.data.name;
          }).catch(err => console.log(err));
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