<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Demandes</span>
            <div>
                <router-link to="/demande/create" class="btn btn-primary">
                    Nouvelle Demande
                </router-link>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Agent</th>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                        <td class="w-4">{{item.id}}</td>
                        <td class="w-6">{{item.agent.text}}</td>
                        <td class="w-6">{{item.created_at | timeformat}}</td>
                        <td class="w-6">{{item.agent.service.name}}</td>
                        <router-link  :to="{path : '/demande/'+item.id}">
                        <td class="w-3">
                            <span class="text-primary m-2" data-toggle="tooltip" data-placement="top" title="Détails" style=" cursor: pointer;">
                                <i class="far fa-eye" ></i>
                             </span>
                        </td>
                        </router-link>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer flex-between">
            <div>
                <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
            </div>
            <div>
                <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="prevPage">
                    Prev
                </button>
                <button class="btn btn-sm" :disabled="!model.next_page_url" @click="nextPage">
                    Suivant
                </button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import { get } from '../../lib/api'
    export default {
        data () {
            return {
            article :'/demande/create',
                model: {
                    data: []
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get('/api/demande', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/demamde', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
         
            detailsPage(item) {
                this.$router.push(`/demande/${item.id}`)
            },
            setData(res) {
                Vue.set(this.$data, 'model', res.data.results)
                this.page = this.model.current_page
            },
            nextPage() {
                if(this.model.next_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) + 1) : 2

                    this.$router.push({
                        path: '/demande',
                        query: query
                    })
                }
            },
            prevPage () {
                if(this.model.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1

                    this.$router.push({
                        path: '/demande',
                        query: query
                    })
                }
            }
        }
    }
</script>
