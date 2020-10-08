<template>
<div>
      <div class="card-header mb-3">
        <h5 class="title">Ajouter un Demmande</h5>
        </div>
  <div class="row m-2">
    <div class="col-md-12">
    <div class="card p-4">
      <div class="card-body">
          <form @submit.prevent="updateFourn" enctype="multipart/form-data">
         <div class="form-row">
             <div class="col-4">
        <select id="cars1"  name="marque" class="form-control mb-3 combo" >
               <option  selected>Veuillez choisir une  Agent </option>
        </select>
        </div>
  </div>
          <div class="form-row">
              <div class="col">
        <select id="cars1" name="marque" class="form-control mb-3 combo" >
              <option  selected>Veuillez choisir un Article </option>
        </select>
        </div>
           <div class="col">
      <input type="text" class="form-control" placeholder="marque">
    </div>
    <div class="col">
      <input type="text" class="form-control" placeholder="Category">
    </div>
    <div class="col">
      <input type="text" class="form-control" placeholder="Modele">
    </div>
    <div class="col">
    <span class="badge badge-dark">
    <i class="fas fa-plus ml-2"></i></span>
        </div>
    </div>

        <div class="form-row">
            <div class="col-2">
                <label for="">choisir la Quantité</label>
                <input type="number" class="form-control" placeholder="0">
            </div>
        </div>
        <div class="mb-4">
         <button type="button" class="btn btn-secondary">Close</button>
        <button type="submit" class="btn btn-success">Confirmer</button>
        </div>
        </form>
         </div> 
       </div>
    </div>
    </div>
  </div>

</template>
<script>
export default {
    data(){
        return{
         
        }
    },
    created(){
       
    },
    methods:{
      
    }
}
</script>