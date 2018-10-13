//TOOLTIP
$(window).load(function(e) {
		var w_tooltip = $(".tooltip").width();;
		var h_tooltip = 0;
		var pad = 10; 
		var x_mouse = 0; var y_mouse = 0;
		var wrap_left = 0;
		var wrap_right = 0;
		var wrap_top = 0;
		var wrap_bottom = 0;
		
    $(".product_list li").mousemove(function(e){
			wrap_left = $(this).parent().offset().left;
			wrap_top = $(this).parent().offset().top;
			wrap_bottom = $(this).parent().offset().top + $(this).parents(".product_list").height();
			x_mouse = e.pageX - $(this).offset().left;
			y_mouse = e.pageY - $(this).offset().top;
			h_tooltip = $(this).children(".tooltip").height();
			$(".tooltip").hide();
			
           
			//Di chuyển theo chiều ngang
			if($(this).offset().left - pad - w_tooltip > wrap_left){
				$(this).children(".tooltip").css("left", 0-(w_tooltip + pad) + x_mouse);
			}else{
				$(this).children(".tooltip").css("left",pad + x_mouse);
				}
			
			//Di chuyển theo chiều dọc		
			if(e.pageY + h_tooltip >= $(window).height() + $(window).scrollTop()){
				$(this).children(".tooltip").css("top", y_mouse - h_tooltip - pad)
			}else{
				$(this).children(".tooltip").css("top", pad+ y_mouse);
				}
			//Show tooltip	
			$(this).children(".tooltip").show();
			});
			
		$(".product_list li").mouseout(function(){
			$(".tooltip").hide();
			});
  });