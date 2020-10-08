export default {
    setLogin: function(data){
        localStorage.setItem("username",data.user.name);
        localStorage.setItem("userid",data.user._id);
        localStorage.setItem("token",data.token);
    } ,
    getLogin: function(){
        return {
            name:localStorage.getItem("username"),
            id:localStorage.getItem("userid"),
            token:localStorage.getItem("token")
        }
    },
    logout:function(){
         localStorage.removeItem("username");
        localStorage.removeItem("userid");
        localStorage.removeItem("token");
    }  , 
     delete_cookie:function( name, path, domain ) {
        if( get_cookie( name ) ) {
          document.cookie = name + "=" +
            ((path) ? ";path="+path:"")+
            ((domain)?";domain="+domain:"") +
            ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
        }
      }
}