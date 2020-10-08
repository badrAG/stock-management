<template>
<nav>
    <div class="wrapper" id="#wrapper">


        <div class="main_body">
            <div class="sidebar_menu">
            <div class="sidebar-heade">
              <div class="user-pic">
                <img class="img-responsive img-rounded" :src="photo"
                  alt="User picture">
              </div>
              <div class="user-info">
                <span class="user-name"><strong>{{ name }}</strong></span>
                <span class="user-role">Admin</span>
                <span class="user-status">
                  <i class="fa fa-circle"></i>
                  <span>Online</span>
                </span>
              </div>
         <i class="fas fa-power-off offbtn text-danger" @click.prevent="logouts" 
         data-toggle="tooltip" data-placement="bottom" title="Déconnexion"></i>
          <router-link :to="profile">
       <i   data-toggle="tooltip" data-placement="bottom" title="Profile" 
       class="fas fa-user-cog probtn text-success"></i>
              </router-link>
            </div>
            <hr>
                <div class="inner__sidebar_menu">
                <!---->
                    <ul>
                      <li>
                        <router-link :to="dashboard" class="choix">
                          <span class="icon">
                              <i class="fas fa-border-all"></i></span>
                          <span class="list">Dashboard</span>
                        </router-link>
                      </li>
                       <li>
                        <a class="downAr choix" >
                          <span class="icon"><i class="fas fa-box"></i></span>
                          <span class="list">Article</span>
                          <span class="spdown">
                              <i class="fas fa-chevron-down"></i>
                              <i class="fas fa-chevron-up" style="display:none"></i>
                            </span>
                        </a>
                        <ul  class='Archix' style="display:none">
                              <li>
                                  <router-link class="contdawn" :to="article">
                                  <span class="icon"><i class="fas fa-cubes"></i></span>
                                  <span class="list"> Tous les Articles</span>
                                  </router-link>
                                </li>
                              <li>
                               <router-link class="contdawn" :to="reteurn">
                                  <span class="icon"><i class="fas fa-cart-arrow-down"></i></span>
                                  <span class="list"> retourns</span>
                                </router-link>
                                </li>
                                <li>
                                 <router-link class="contdawn" :to="demmande">
                                  <span class="icon"><i class="fas fa-cart-plus"></i></span>
                                  <span class="list"> Demandes</span>
                                  </router-link>
                                </li>
                          </ul>
                      </li>
                        <li>
                          <router-link class="choix" :to="agent">
                          <span class="icon"><i class="fas fa-user-tie"></i></span>
                          <span class="list"> Agents</span>
                          </router-link>
                        </li>
                      <li>
                          <router-link class="choix" :to="fornisseur">
                          <span class="icon"><i class="fas fa-user-tag"></i></span>
                          <span class="list"> Fournisseur</span>
                          </router-link>
                        </li>
                      <li>
                        <router-link class="choix" :to="marque">
                          <span class="icon"><i class="fas fa-tags"></i></span>
                          <span class="list">Marques</span>
                         </router-link>
                      </li>
                      <li>
                        <router-link :to="category" class="choix">
                          <span class="icon"><i class="far fa-clone"></i></span>
                          <span class="list">Catégories</span>
                        </router-link>
                      </li>
                       <li>
                          <router-link :to="modele" class="choix">
                          <span class="icon"><i class="fab fa-buffer"></i></span>
                          <span class="list">Modéles</span>
                          </router-link>
                      </li>
                     <li>
                          <router-link :to="service" class="choix">
                          <span class="icon"><i class="fas fa-briefcase"></i></span>
                          <span class="list">Services</span>
                          </router-link>
                      </li>
                      <li>
                          <router-link :to="admin" class="choix">
                          <span class="icon"><i class="fas fa-users-cog"></i></span>
                          <span class="list">Admins</span>
                          </router-link>
                      </li>
                       
                    </ul>

                    <div class="hamburger">
                        <div class="inner_hamburger">
                            <span class="arrow">
                                <i class="fas fa-long-arrow-alt-left"></i>
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </span>
                        </div>
                    </div>
    
                </div>
            </div>
 </div>
 </div>
 </nav>
</template>
<script>
export default {
  data:()=>({
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  }),
    data(){

        return{
            logout:'/logout',
            article :'/article',
            profile :'/admin/profile',
            marque :'/marque',
            modele :'/modele',
            fornisseur:'/fournisseur',
            agent:'/agent',
            dashboard :'/dashboard',
            category :'/category',
            reteurn :'/retourn',
            demmande :'/demande',
            service :'/service',
            admin :'/admin',
            name : "",
            photo:''
        }

    },
     methods:{
            logouts:function(){
               axios.post('logout').then(response => {
                  if (response.status === 302 || 401) {
                    this.$router.go();
                  }
                  else {
                    // throw error and go to catch block
                  }
                }).catch(error => {

              });
            },
             getArticle(){
          axios.get('/api/admin/profile')
          .then(res => {
            this.name =  res.data.name;
            this.photo =  res.data.image;
           
          }).catch(err => console.log(err));
        },
        },
         created(){
            this.getArticle();
    },
}
</script>