$(document).ready(function(){
    var xOffset = -10;
    var yOffset = 10;
    var v_width = $(window).width();
    var v_height = $(window).height();
    var v_w_t = 320;
    
    // Begin Tooltip
    $(".vnit_tip").mousemove(
    function(e){        
        this.top = (e.pageY + yOffset); 
        this.left = (e.pageX + xOffset); 

        var vnit_tip_id = $(this).attr('id');
        var vnit_tip_content = $(this).find("#vtip").show(); 

        $(this).find("#vtip").css('top', e.pageY + 10 ); 
        $(this).find("#vtip").css('width', v_w_t-30+'px' );
        if((e.pageX + v_w_t) < v_width){
            $(this).find("#vtip").css('left', e.pageX + 20 );            
                        
        }else{
            $(this).find("#vtip").css('left',e.pageX - (v_w_t) );
        }
    }).mousemove(function(e) {
        
        $(this).find("#vtip").css('top', e.pageY  + 10 );
        $(this).find("#vtip").css('width', v_w_t-30+'px' );
        if((e.pageX + v_w_t) < v_width){
            $(this).find("#vtip").css('left', e.pageX + 20 );            
        }else{
            $(this).find("#vtip").css('left', e.pageX - (v_w_t) ); 
        }        
        
    }).mouseout(function() {
    
        $(this).find("#vtip").hide();
        
    });
});