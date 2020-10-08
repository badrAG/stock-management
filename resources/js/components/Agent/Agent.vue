<template>
    <div>
        <AddAgent @added="agentAdded"></AddAgent>
     <div class="card-header mb-3"><h3>Les Agents</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <button class="btn btn-primary ajoute" data-toggle="modal" data-target="#agentModal"
                 type="button"> <i class="fas fa-plus m-2 "></i>Ajouter Un Agent</button>
            </div>
            <div class="col-md-4 cont-searsh">
                <input type="text" class="search rigth" placeholder="Rechercher" v-model="searchQuery" name="search" id="search"><i class="fas fa-search icSearsh"></i>
            </div>
        </div>
         <div class="col-md-12">
             
                <div class="card p-4">
             <table class="table">
                 <thead class="thead-dark">
                     <tr>
                         <th class="p-2 text-center" scope="col"><span>Nom</span></th>
                         <th class="p-2 text-center" scope="col"><span>Prénom</span></th>
                         <th class="p-2 text-center" scope="col"><span>Email</span></th>
                         <th class="p-2 text-center" scope="col"><span>Téléphone</span></th>
                         <th class="p-2 text-center" scope="col"><span>Service</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>

                     </tr>
                 </thead>
                <thead v-if="resultQuery.length" >
                    <tr v-for="(agent,index) in resultQuery" :key="index">
                         
                        <td  class="p-2 text-center" target="_blank">{{agent.nom}}</td>
                        <td  class="p-2 text-center">{{agent.prenom}}</td>
                        <td  class="p-2 text-center"> {{agent.Email}}</td>
                        <td  class="p-2 text-center">{{agent.tele}}</td>
                        <td  class="p-2 text-center">{{agent.service.name}}</td>

                        <td  class="p-2 text-center">
                           
                              <router-link :to="{path : 'agent/edit/'+agent.id}">
                            <span class="text-success m-2" style="cursor: pointer;">
                                <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modifier"></i>
                                </span>
                           </router-link>
                            
                            <a @click="deleteArticle(agent.id)">
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
                <pagination :data="agents" @pagination-change-page="getArticle"></pagination>
             </div>

               
            </div>
    </div>

</template>
<script>

import AddAgent from './AddAgent';

export default {
      data(){
         return{
             searchQuery: null,
            agents:[]
            }
        } ,
        created(){
            this.getArticle();
        },
        components: {AddAgent},
           computed: {
    resultQuery(){
      if(this.searchQuery){
      return this.agents.data.filter((item)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => item.nom.toLowerCase().includes(v))
      })
      }else{
        return this.agents.data;
      }
    }
  },
        methods:{
            getArticle(page){
                if( typeof page===undefined){
                    page=1;
                }
                axios.get('/api/agent?page='+page)
                .then(Response=> {
                    this.agents = Response.data;})
                .catch(err=>console.log(err));
            },
            agentAdded(){
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
                 axios.delete(`/api/agent/${id}`).then(res=>{
                       Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Agent supprimé',
                   showConfirmButton: false,
                   timer: 2500
                  });
                     this.getArticle();
                 }).catch(
                     Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas supprimer ce agent, qui peut avoir des commandes!',
                        })
                 );
                        }
                  
            })
        }

    }
}
</script>