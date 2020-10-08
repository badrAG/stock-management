<template>
      <div class="modal fade" id="servModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="addService" enctype="multipart/form-data">
          <div class="form-group">
        <input type="text" v-model="name" class="form-control mb-1" :class="{'jst is-invalid':errors.name}" placeholder="Nouvelle Service">
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
</template>
<script>
export default {
    data(){
        return{
          errors:{},
            name : '',
        }
    },
    created(){},
    methods:{
        addService(e){
            e.preventDefault();
            const config = {
                headers : { "content-type" : "multipart/form-data" }
            }
            let formData = new FormData();
            formData.append("name",this.name);
            axios.post("api/service",formData,config)
            .then(res => {
                $('#servModal').modal('hide');
                this.name = '';
                Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: 'Le service a été ajouté',
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