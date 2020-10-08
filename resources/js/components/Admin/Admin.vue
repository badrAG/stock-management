<template>
    <div>
        <AddAmin @added="agentAdded"></AddAmin>
     <div class="card-header mb-3"><h3>Les Admins</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <button class="btn btn-primary ajoute" data-toggle="modal" data-target="#addadmin"
                 type="button"> <i class="fas fa-plus m-2 "></i>Ajouter Un Admin</button>
            </div>
            <div class="col-md-4 cont-searsh">
                <input type="search" placeholder="Rechercher" class="search rigth" v-model="searchQuery" name="search" id="search"><i class="fas fa-search icSearsh"></i>
            </div>
        </div>
         <div class="col-md-12">
             
                <div class="card p-4">
             <table class="table">
                 <thead class="thead-dark">
                     <tr>
                         <th class="p-2 text-center" scope="col"><span>ID</span></th>
                         <th class="p-2 text-center" scope="col"><span>Nom</span></th>
                         <th class="p-2 text-center" scope="col"><span>Email</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>

                     </tr>
                 </thead>
                <thead  v-if="resultQuery.length" >
                     <tr v-for="(admin,index) in resultQuery" :key="index">
                        <td  class="p-2 text-center">{{admin.id}}</td>
                        <td  class="p-2 text-center" target="_blank">{{admin.name}}</td>
                        <td  class="p-2 text-center">{{admin.email}}</td>
                        <td  class="p-2 text-center">
                                  <router-link :to="{path : 'admin/e/'+admin.id}">
                            <span class="text-success m-2" style="cursor: pointer;">
                                <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modifier"></i>
                                </span>
                           </router-link>
                            
                            <a @click="deleteArticle(admin.id)">
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
            <td class="footaucan"> Aucun Élément </td>
            <td class="foot"></td>
            </tfoot>
             </table>
             </div>
             <div class="card-footer">
                <pagination :data="admins" @pagination-change-page="getArticle"></pagination>
             </div>
            </div>
    </div>

</template>
<script>

import AddAmin from './AddAdmin';

export default {
      data(){
         return{
            admins:[],
            searchQuery:null
            }
        } ,
        created(){
            this.getArticle();
        },
        components: {AddAmin},
         computed: {
         resultQuery(){
      if(this.searchQuery){
      return this.admins.data.filter((item)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
      })
      }else{
        return this.admins.data;
      }
    }
  },
        methods:{
            getArticle(page){
                if(typeof page === undefined){
                    page = 1;
                }
                    axios.get("api/admin?page="+page).then(({ data
                     }) => (this.admins = data));
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
                 axios.delete(`/api/admin/${id}`).then(res=>{
                       Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Admin supprimé',
                   showConfirmButton: false,
                   timer: 2500
                  });
                     this.getArticle();
                 }).catch(
                     Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas supprimer ce Admin',
                        })
                 );
                        }
                  
            })
        }

    }
}
</script>