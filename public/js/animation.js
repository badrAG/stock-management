$(document).ready(function(){
    $(".fa-edit").hover(function(){
      $(this).css("background-color","green")
    })
    
      $('.downAr').on('click',function(){
        $('.Archix').slideToggle();

      $(".downAr").toggleClass("active");
      })
});
$("p").hover(function(){
    $(this).css("background-color", "yellow");
    }, function(){
    $(this).css("background-color", "pink");
  });
  