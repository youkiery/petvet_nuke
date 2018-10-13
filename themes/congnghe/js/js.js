
$(function() {
         
         	$('.dropdown-menu input').click(function(e) {
         
         		e.stopPropagation();
         
         	});
         
         	$('#main_slide').carousel({
         
         		interval: 4000
         
         	})
         
         	$('#productslide').carousel({
         
         		interval: 15000
         
         	})
         
         });			
         
         jQuery(function($){				
         
         	$('.bar').mosaic({
         
         		animation:'slide'
         
         	});
         
         });
                  $(function() {
         
         	
         
         	$('.dropdown-menu input').click(function(e) {
         
         	e.stopPropagation();
         
         });
         
         function DropDown(el) {
         
         			this.dd = el;
         
         			this.initEvents();
         
         		}
         
         		DropDown.prototype = {
         
         			initEvents : function() {
         
         				var obj = this;
         
         
         
         				obj.dd.on('click', function(event){
         
         					$(this).toggleClass('active');
         
         					event.stopPropagation();
         
         				});	
         
         			}
         
         		}
         
         
         
         		
         
         		$(function() {
         
         
         
         			var dd = new DropDown( $('#dd') );
         
         
         
         			$(document).click(function() {
         
         				// all dropdowns
         
         				$('.menu-drop').removeClass('active');
         
         			});
         
         
         
         		});
         
         		
         
         			
         
         });
         
          $(document).ready(function() {
       //Tooltips
        var tip = null;

        $(".tooltip").hover(function(){

            //Caching the tooltip and removing it from container; then appending it to the body
            tip = $(this).find('.tip').remove();
            $('body').append(tip);
            tip.show(); //Show tooltip

        }, function() {

            tip.hide().remove(); //Hide and remove tooltip appended to the body
            $(this).append(tip); //Return the tooltip to its original position

        }).mousemove(function(e) {
        //console.log(e.pageX)
              if ( tip == null ) return;
              var mousex = e.pageX + 20; //Get X coodrinates
              var mousey = e.pageY + 20; //Get Y coordinates
              var tipWidth = tip.width(); //Find width of tooltip
              var tipHeight = tip.height(); //Find height of tooltip

             //Distance of element from the right edge of viewport
              var tipVisX = $(window).width() - (mousex + tipWidth);
              var tipVisY = $(window).height() - (mousey + tipHeight);

            if ( tipVisX < 20 ) { //If tooltip exceeds the X coordinate of viewport
                mousex = e.pageX - tipWidth - 20;
                $(this).find('.tip').css({  top: mousey, left: mousex });
            } if ( tipVisY < 20 ) { //If tooltip exceeds the Y coordinate of viewport
                mousey = e.pageY - tipHeight - 20;
                tip.css({  top: mousey, left: mousex });
            } else {
                tip.css({  top: mousey, left: mousex });
            }
        });
    });