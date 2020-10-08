<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{ title }} Demande</span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label><b> Agent :</b></label>
                        <typeahead :url="customerURL" :initialize="form.agent"
                            @input="onCustomer" />
                        <p class="error-control text-danger" v-if="errors.agent_id">
                            {{errors.agent_id[0]}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
               
            </div>
            <hr>
            <table class="form-table">
                <thead>
                    <tr>
                        <th >Article Description</th>
                        <th class="p-2 text-center" scope="col">Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in form.articles" :key="index">
                        <td scope="row" class="w-14">
                            <typeahead :url="productURL" :initialize="item.article"
                                @input="onProduct(index, $event)" />
                              <p class="error-control text-danger" v-if="errors[`articles.${index}.article_id`]">
                                {{errors[`articles.${index}.article_id`][0]}}
                            </p>
                        </td>
                    
                        <td scope="row" class="w-2">
                            <input style="margin-left: 12px" type="text" class="form-control" v-model="item.qnt">
                               <p class="error-control text-danger" v-if="errors[`articles.${index}.qnt`]">
                                {{errors[`articles.${index}.qnt`][0]}}
                            </p>
                        </td>
                    
                        <td scope="row">
                            <span  class="form-remove" data-toggle="tooltip" data-placement="top" title="Supprimer" @click="removeItem(index)">&times;</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-sm nligne"
                             @click="addNewLine">Nouvelle Ligne</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <hr>
        </div>
        <div class="panel-footer flex-end">
            <div>
                <button class="btn btn-primary" :disabled="isProcessing" @click="onSave">Confirmer</button>
                <button class="btn btn-light" :disabled="isProcessing" @click="onCancel">Annuler</button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
   import Vue from 'vue'
    import {get, byMethod } from '../../lib/api'
    import {Typeahead } from '../../components/typeahead'

     function initialize(to) {
        let urls = {
            'create': `/api/demande/create`,
            'edit': `/api/demande/${to.params.id}/edit`
        }

        return (urls[to.meta.mode] || urls['create']);
    }/**/
    export default {
        components: { Typeahead},
        data () {
            return {
                form: {},
                errors: {},
                isProcessing: false,
                show: false,
                resource: '/demande',
                store: '/api/demande',
                method: 'POST',
                title: 'Ajouter',
                productURL: '/api/articles',
                customerURL: '/api/agents'
            }
        },
        beforeRouteEnter(to, from, next) {
            get(initialize(to))
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(initialize(to))
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
      
        methods: {
            setData(res) {
                Vue.set(this.$data, 'form', res.data.form)

                if(this.$route.meta.mode === 'edit') {
                    this.store = `/api/demande/${this.$route.params.id}`
                    this.method = 'PUT'
                    this.title = 'Modifier'
                }

                this.show = true
               this.$bar.finish()
            },
            addNewLine() {
                this.form.articles.push({
                    article_id: null,
                    article: null,
                    qnt: 1
                })
            },
            onCustomer(e) {
                const agent = e.target.value
                Vue.set(this.$data.form, 'agent', agent)
                Vue.set(this.$data.form, 'agent_id', agent.id)
            },
            onProduct(index, e) {
                const article = e.target.value
                Vue.set(this.form.articles[index], 'article', article)
                Vue.set(this.form.articles[index], 'article_id', article.id)

            },
            removeItem(index) {
                this.form.articles.splice(index, 1)
            },
            onCancel() {
                if(this.$route.meta.mode === 'edit') {
                    this.$router.push(`${this.resource}/${this.form.id}`)
                } else {
                    this.$router.push(`${this.resource}`)
                }
            },
        
            onSave() {
                let forms= this.form.articles;
                this.errors = {}
                this.isProcessing = true
                byMethod(this.method, this.store, this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(res)
                         
                         forms.forEach(element => {
                              var newqnt= element.article.qnt - element.qnt;
                              const config = {
                                  headers : { "content-type" : "multipart/form-data" }
                             }
                            let formData = new FormData();
                             formData.append("image",element.article.photo);
                             formData.append("libelle",element.article.libelle);
                             formData.append("qnt",newqnt);
                             formData.append("prix",element.article.prix);
                             formData.append("category_id",element.article.category_id);
                             formData.append("marque_id",element.article.marque_id);
                             formData.append("modele_id",element.article.modele_id);
                             formData.append("fournisseur_id",element.article.fournisseur_id);
                            formData.append("_method","put");
                            axios.post(`/api/article/${element.article.slug}`,formData,config)
                         });
                             Swal.fire({
                                 position: 'center',
                                 icon: 'success',
                                 title: 'L\'opération s\'est terminée avec succès',
                                 showConfirmButton: false,
                                 timer: 2500
                                 })
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.errors = error.response.data.errors

                        }
                        this.isProcessing = false
                    })
            },
            success(res) {
                this.$router.push(`${this.resource}/${res.data.id}`)
            }
        }
    }
</script>
