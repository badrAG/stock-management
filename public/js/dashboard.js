$(document).ready(function(){
    $(".hamburger").click(function(){
      $(".wrapper").toggleClass("active")
      $("#trans").toggleClass("active")
    })
    
      $('.downAr').on('click',function(){
        $('.Archix').slideToggle();

      $(".downAr").toggleClass("active");
      })
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})