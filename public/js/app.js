  $( ".dashbox" ).fadeIn("slow");

  $(".dashbox").mouseover(function(){
  	$(this).css('background-color','black');
  	$(this).css('color','white');
  	$(this).find('.swordicon').show();
  })

  $(".dashbox").mouseout(function(){
  	$(this).css('background-color','transparent');
  	$(this).css('color','black');
  	$('.swordicon').hide();
  })


