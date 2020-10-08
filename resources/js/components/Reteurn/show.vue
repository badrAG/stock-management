<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{model.number}}</span>
            <div>
                <router-link to="/retourn" class="btn btn-secondary">Retour</router-link>
                <router-link :to="`/retourn/${model.id}/edit`" class="btn btn-secondary">Modifier</router-link>
                <button class="btn btn-danger" @click="deleteItem" data-toggle="tooltip" data-placement="bottom" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
       
        <div class="panel-body" id="print">
            <div class="document">
                <div class="row">
                    <div class="col-8">
                        <span class="document-title">De:</span>
                        <div>
                            <span><strong>Nom et Prénom : </strong></span>
                            <span> {{model.agent.text}}</span>
                            <pre><span><strong>Email : </strong></span>{{model.agent.Email}}</pre>
                            <pre><span><strong>Téléphone : </strong></span>{{model.agent.tele}}</pre>
                           <pre><span><strong>Service : </strong></span>{{model.agent.service.name}}</pre>
                        </div>
                    </div>
                    <div class="col-8 col-offset-8">
                      
                                        <span class="document-title">Routurn :</span>
                                    <pre><strong>N° :</strong> #{{model.id}}</pre> 
                                    <pre><strong>Date de retourn :</strong> {{model.created_at | timeformat}}</pre>
                    </div>
                </div>
                <div class="document-body">
                    <table class="table document-table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center ">ID</th>
                                <th scope="col" class="text-center ">Libelle</th>
                                <th scope="col" class="text-center ">Quantité</th>
                                <th scope="col" class="text-center ">Catégorie</th>
                                <th scope="col" class="text-center ">Marque</th>
                                <th scope="col" class="text-center ">Modéle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in model.articles" :key="item.id">
                                <td  scope="row" class="w-2 text-center">{{item.article.id}}</td>

                                
                                <td  scope="row" class="w-4 text-center">
                                    <pre>{{item.article.libelle}}</pre>
                                </td>
                                <td  scope="row" class="w-2 text-center">{{item.qnt}}</td>
                                <td  scope="row" class="w-4 text-center">
                                    <pre>{{item.article.category.name}}</pre>
                                </td>
                                <td  scope="row" class="w-2 text-center">
                                    <pre>{{item.article.marque.name}}</pre>
                                </td>
                                <td  scope="row" class="w-3 text-center">
                                    <pre>{{item.article.modele.name}}</pre>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                           
                        </tfoot>
                    </table>
                </div>
               
            </div>
        </div>
        
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod} from '../../lib/api'
    import jspdf from 'jspdf'
    import html2canvas from 'html2canvas'
    export default {
        data () {
            return {
                show: false,
                model: {
                    items: [],
                    customer: {}
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/retourn/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/retourn/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
           
      
            setData(res) {
                console.log(res.data.model)
                Vue.set(this.$data, 'model', res.data.model)
                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
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

                byMethod('delete', `/api/retourn/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Demande supprimé',
                            showConfirmButton: false,
                            timer: 2500
                            });
                            this.$router.push('/retourn')
                        }
                    })
                  }
                   })
            }
        }
    }
</script>
