import Vue from 'vue'
import VueRouter from 'vue-router'

import Article from '../components/Article/Article.vue'
import Fournisseur from '../components/Fournisseur/Fournisseur.vue'
import EditFourn from '../components/Fournisseur/EditFourn.vue'
import Agent from '../components/Agent/Agent.vue'
import EditAgent from '../components/Agent/EditAgent.vue'
import Category from '../components/Category/Category.vue'
import Commander from '../components/Commande/Command.vue'

import Demmande from '../components/Demmand/index.vue'
import DemandeCreate from '../components/Demmand/form.vue'
import DemandeShow from '../components/Demmand/show.vue'
import DemandeEdit from '../components/Demmand/form.vue'

import Reteurn from '../components/Reteurn/index.vue'
import ReteurnCreate from '../components/Reteurn/form.vue'
import ReteurnShow from '../components/Reteurn/show.vue'
import ReteurnEdit from '../components/Reteurn/form.vue'

import Modele from '../components/modele/Modele.vue'
import Marque from '../components/marque/Marque.vue'
import Service from '../components/servicess/Service.vue'
import DetailSevice from '../components/servicess/DetailSevice.vue'
import DetailModele from '../components/modele/DetailModele.vue'
import DetailMarque from '../components/marque/DetailMarque.vue'
import DetailCategory from '../components/Category/DetailCategory.vue'
import DetailFournisseur from '../components/Fournisseur/DetailFournisseur.vue'
import Dashboard from '../components/Dashboard.vue'
import ArticleDetails from '../components/Article/ArticleDetails.vue'
import EditArticle from '../components/Article/EditArticle.vue'
import Admin from '../components/Admin/Admin.vue'
import EditAdmin from '../components/Admin/EditAdmin.vue'
import Profil from '../components/Admin/Profil.vue'
import Logout from '../components/Logout.vue'
Vue.use(VueRouter)

const routes = [
   
   {
    path : '/dashboard',
    component : Dashboard,
    name : 'dashboard'
},
{
    path : '/article',
    component : Article,
    name : 'article'
},
{
    path : '/admin',
    component : Admin,
    name : 'admin'
},
{
    path : '/admin/e/:id',
    component : EditAdmin,
    name : 'editadmin'
},
{
    path : '/admin/profile',
    component : Profil,
    name : 'profil'
},
{
    path : '/fournisseur',
    component : Fournisseur,
    name : 'fournisseur'
},
{
    path : '/fournisseur/edit/:id',
    component : EditFourn,
    name : 'editFourn'
},
{
    path : '/agent',
    component : Agent,
    name : 'agent'
},
{
    path : '/agent/edit/:id',
    component : EditAgent,
    name : 'editAgent'
},
{
    path : '/category',
    component : Category,
    name : 'category'
},
{
    path : '/service',
    component : Service,
    name : 'service'
},
{
    path : '/service/detail/:id',
    component : DetailSevice,
    name : 'detailService'
},
{
    path : '/marque',
    component : Marque,
    name : 'marque'
},
{
    path : '/modele',
    component : Modele,
    name : 'modele'
},
{
    path : '/modele/details/:id',
    component : DetailModele,
    name : 'detailModele'
},
{
    path : '/marque/details/:id',
    component : DetailMarque,
    name : 'detailMarque'
},
{
    path : '/catégorie/details/:id',
    component : DetailCategory,
    name : 'detailCategory'
},
{
    path : '/fournisseur/details/:id',
    component : DetailFournisseur,
    name : 'detailFournisseur'
},
{
    path : '/commander',
    component : Commander,
    name : 'commander'
},
{
    path : '/article/edit/:slug',
    component : EditArticle,
    name : 'editArticle'
},
{   
    path: '/demande',
    component: Demmande,
    name: 'demande'
},
{
    path: '/demande/create',
    component: DemandeCreate,
    name:'demandeCreate'
},
{
    path: '/demande/create', 
    component: DemandeCreate ,
    name: 'demandeCreate'
},
{
    path: '/demande/:id/edit',
     component: DemandeEdit,
      meta: {mode: 'edit'},
      name: 'demandeEdit' 
},
{
    path: '/demande/:id',
     component:DemandeShow,
      name:'demandeShow'
},
{
    path : '/retourn',
    component : Reteurn,
    name : 'retourn'
},
{
    path: '/retourn/create',
    component: ReteurnCreate,
    name:'retournCreate'
},
{
    path: '/retourn/:id/edit',
     component: ReteurnEdit,
      meta: {mode: 'edit'},
      name: 'retournEdit' 
},
{
    path: '/retourn/:id',
     component:ReteurnShow,
      name:'retournShow'
},
{
    path:'/logout',
    component: Logout
}
];
const router = new VueRouter({
    hashbang:false,
    routes,
    mode : 'history'
})
export default router;