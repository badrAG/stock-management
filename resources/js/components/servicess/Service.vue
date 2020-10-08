<template>
    <div>
        <add-service @added="serviceAdded"></add-service>
         <div class="modal fade" id="edservModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="updateSevice(names.id)" enctype="multipart/form-data">
          <div class="form-group">
        <input type="text" v-model="names.name" class="form-control mb-A" :class="{'jst is-invalid':errors.name}" placeholder="Nom">
        <p class="error-control text-danger" v-if="errors.name">
            {{errors.name[0]}}
         </p>
        </div>
          
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
</form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
     <div class="card-header mb-3"><h3>Les Services</h3></div>
        <div class="row m-2">
            <div class="col-md-8">
                <button class="btn btn-primary ajoute" data-toggle="modal" data-target="#servModal"
                 type="button"> <i class="fas fa-plus m-2 "></i>Ajouter Un Service</button>
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
                         <th class="p-2 text-center" scope="col"><span>Ref Modèle</span></th>
                         <th class="p-2 text-center" scope="col"><span>Nom</span></th>
                         <th class="p-2 text-center" scope="col"><span>Action</span></th>
                     </tr>
                 </thead>
                <thead v-if="resultQuery.length">
                    <tr v-for="(service,index) in resultQuery" :key="index">
                        <td  class="p-2 text-center">{{service.id}}</td>
                        <td  class="p-2 text-center" target="_blank">{{service.name}}</td>
                        <td  class="p-2 text-center">
                        <router-link  :to="{path : '/service/detail/'+service.id}">
                          <span class="text-primary m-2" data-toggle="tooltip" data-placement="top" title="Détails" style=" cursor: pointer;">
                                <i class="far fa-eye" ></i>
                             </span>
                        </router-link>
                            <span class="text-success m-2" data-toggle="modal" @click="editserv(service.id)" style="cursor: pointer;">
                                <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modifier"></i>
                                </span>
                            
                            <a @click="deleteArticle(service.id)">
                                <span class="text-danger"  style=" cursor: pointer;">
                                <i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Supprimer"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </thead>
                  <tfoot v-else class="tftest">
            <td class="foot"></td>
            <td class="footaucan"> Aucun Élément </td>
            <td class="foot"></td>
            </tfoot>
             </table>
                </div>
                  <div class="card-footer">
                <pagination :data="services" @pagination-change-page="getArticle"></pagination>
             </div>
            </div>
    </div>

</template>
<script>

import AddService from './AddService.vue'
export default {
      data(){
         return{
             names:{},
             errors:{},
            services:[],
            searchQuery:null
            }
        } ,
        created(){
            this.getArticle();
        },
        components: {AddService},
         computed: {
         resultQuery(){
      if(this.searchQuery){
      return this.services.data.filter((item)=>{
        return this.searchQuery.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
      })
      }else{
        return this.services.data;
      }
    }
  },
        methods:{
              updateSevice(id){
                const config = {
                    headers : { "content-type" : "multipart/form-data" }
                }
                let formData = new FormData();
                formData.append("name",this.names.name);
                formData.append("_method","put");
                axios.post(`/api/service/${id}`,formData,config)
                .then(res => {
                    $('#edservModal').modal('hide');
                    this.name = '';
                       Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'La service a été modifié',
                   showConfirmButton: false,
                   timer: 2500
                  })
                    this.getArticle();
                    this.$emit('edit');
                }).catch((error)=>{
              if(error.response.status === 422) {
                this.errors = error.response.data.errors
              }
            })
            },
            
            editserv(id){
                $('#edservModal').modal('show');
                 axios.get(`/api/service/${id}`)
          .then(res => {
            console.log(res.data);
            this.names =  res.data;
          }).catch(err => console.log(err));
            },
            getArticle(page){
               if(typeof page === undefined){
                    page=1;
                }
                axios.get('/api/service?page='+page)
                .then(Response=> {
                    console.log(Response.data);
                    this.services = Response.data;})
                .catch(err=>console.log(err));
            },
            serviceAdded(){
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

                       axios.delete(`/api/service/${id}`).then(res=>{
                            Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Service supprimé',
                   showConfirmButton: false,
                   timer: 2500
                  });
                     this.getArticle();

                 }).catch( Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas supprimer ce Service qui peut contenir certains agent!',
                        }));
                }

              })
            }
        }

}
</script>