<template>
      <div class="modal fade" id="agentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un Agent</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="addAgent" enctype="multipart/form-data">
          <div class="form-group">
        <input type="text" v-model="nom" class="form-control mb-1" :class="{'jst is-invalid':errors.nom}" placeholder="Nom">
         <p class="error-control text-danger" v-if="errors.nom">
            {{errors.nom[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="prenom" class="form-control mb-1" :class="{'jst is-invalid':errors.prenom}" placeholder="Prénom">
        <p class="error-control text-danger" v-if="errors.prenom">
            {{errors.prenom[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="Email" class="form-control mb-1" :class="{'jst is-invalid':errors.Email}" placeholder="Email">
          <p class="error-control text-danger" v-if="errors.Email">
            {{errors.Email[0]}}
         </p>
        </div>
          <div class="form-group">
        <input type="text" v-model="tele" class="form-control mb-1" :class="{'jst is-invalid':errors.tele}" placeholder="Téléphone">
          <p class="error-control text-danger" v-if="errors.tele">
            {{errors.tele[0]}}
         </p>
        </div>
          <div class="form-group">
        <select id="carss" v-model="service" name="service" class="form-control mb-1 combo" :class="{'jst is-invalid':errors.service_id}">
              <option  value="">Veuillez choisir une  Service </option>
            <option :value="service.id"  v-for="(service,index) in services.data" :key="index">
                {{ service.name }}
            </option>
        </select>
          <p class="error-control text-danger" v-if="errors.service_id">
            {{errors.service_id[0]}}
         </p>
          </div>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
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
            nom : '',
            prenom : '',
            Email : '',
            tele : '',
            service : '',
            services : []
        }
    },
    created(){
            this.getArticle();
    },
    methods:{
       getArticle(){
                axios.get('/api/service')
                .then(Response=> {
                    this.services = Response.data;})
                .catch(err=>console.log(err));
            },
        addAgent(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("nom",this.nom);
            formData.append("prenom",this.prenom);
            formData.append("Email",this.Email);
            formData.append("tele",this.tele);
            formData.append("service_id",this.service);
            axios.post("api/agent",formData,config)
            .then(res => {
                $('#agentModal').modal('hide');
                this.nom = '';
                this.prenom = '';
                this.Email = '';
                this.tele = '';
                this.service = '';
                    Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Agent ajouté',
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