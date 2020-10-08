<template>
  <div>
    <h2 class="title" >Dashboard</h2>
    <section class="statis text-center">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
              <div class="box bg-primary">
                 <i class="fas fa-box" aria-hidden="true"></i>
                <h3>{{ articles }}</h3>
                <p class="lead">Articles</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box danger">
                <i class="fas fa-user-tie" aria-hidden="true"></i>
                <h3>{{ count_agent }}</h3>
                <p class="lead">Agents</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box warning">
                <i class="fa fa-retweet" aria-hidden="true"></i>
                <h3>{{ count_reteurn }}</h3>
                <p class="lead">Articles retournés</p>
                <small class="mois">Cet mois</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box success">
                <i class="fas fa-cart-plus" aria-hidden="true"></i>
                <h3>{{count_demmand}}</h3>
                <p class="lead">Demandes</p>
                <small class="mois">Cet mois</small>
              </div>
            </div>
          </div>
        </div>
        </section>
        <section>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><p class="lead"  style="margin:0;">Nouvelle Articles</p></div>
            <div class="card-body tab-cont">
             <table class="dv-table">
                 <thead>
                     <tr>
                         <th class="p-2 "><span>Image</span></th>
                         <th class="p-2 text-center"><span>Libelle</span></th>
                         <th class="p-2 text-center"><span>Prix</span></th>
                         <th class="p-2 text-center"><span>Category</span></th>
                         <th class="p-2 text-center"><span>Marque</span></th>
                         <th class="p-2 text-center"><span>Modele</span></th>
                     </tr>
                 </thead>
                <thead>
                    <tr v-for="(last_demmande,index) in last_articles.data" :key="index">
                          <img :src="last_demmande.photo" alt="photo" style="width: 72px; margin-bottom: 9px" class="rounded">
                        <td class="p-2 text-center">{{last_demmande.libelle}}</td>
                        <td class="p-2 text-center">{{last_demmande.prix}} DH</td>
                        <td class="p-2 text-center"> {{last_demmande.category.name}}</td>
                        <td class="p-2 text-center">{{last_demmande.marque.name}}</td>
                        <td class="p-2 text-center">{{last_demmande.modele.name}}</td>
                    </tr>
                </thead>
             </table>
                 </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><p class="lead" style="margin:0;">Nouvelle Demande</p></div>
                      <div class="card-body tab-cont">
                       <table class="dv-table">
                          <thead>
                            <tr>
                             <th class="p-2 text-center"><span>ID Demande</span></th>
                             <th class="p-2 text-center"><span>Agent</span></th>
                             <th class="p-2 text-center"><span>Date Demande</span></th>
                             <th class="p-2 text-center"><span>Service</span></th>
                            </tr>
                          </thead>
                          <thead>
                            <tr v-for="(last_demande,index) in last_demandes.data" :key="index">
                              <td class="p-2 text-center">{{last_demande.id}}</td>
                              <td class="p-2 text-center">{{last_demande.agent.text}}</td>
                              <td class="p-2 text-center">{{last_demande.created_at | timeformat}}</td>
                              <td class="p-2 text-center">{{last_demande.agent.service.name}}</td>
                            </tr>
                          </thead>
                       </table>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </section>
         </div>
       </template>
<script>
export default {
     data(){
         return{
            articles:'',
            count_command:'',
            count_demmand:'',
            count_reteurn:'',
            count_agent:'',
            last_articles:{},
            last_demandes:{}
            }
        },
        created(){
            this.getArticle();
        },
        methods:{
            getArticle(){
                axios.get('/api/dashboard')
                .then(Response=> {
                  this.last_demandes= Response.data.results;
                    this.articles = Response.data.count_article;
                    this.count_demmand = Response.data.count_demmande;
                    this.count_reteurn = Response.data.count_return;
                    this.last_articles = Response.data.last_article;
                    this.count_agent = Response.data.count_agent;
                  })
                .catch(err=>console.log(err));
            }
        }

}
</script>