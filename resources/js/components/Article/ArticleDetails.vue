<template>
    <div>
this details
    </div>
</template>
<script>
export default {
      data(){
        return{
            article : ''
        }
    },
    created(){
        axios.get(`/api/article/${this.$route.params.slug}`)
        .then(response=> {
            console.log( response.data);
            this.article= response.data;
        }).catch(err=>console.log(err));
    }
}
</script>