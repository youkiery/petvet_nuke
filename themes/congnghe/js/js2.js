
         var myVar = null;
         $(function(){
         	e = "";
         	_max = "138880000";
         	_min = "75000";
         	if(e!='') {
         		s1 = e.split("-")[0];
         		s2 = e.split("-")[1];
         	} else {
         		s1 = _min;
         		s2 = _max;	
         	}	
         	$(".noUiSlider").noUiSlider({
         		range: [_min, _max]
         
         	   ,start: [s1, s2]
         
         	   ,handles: 2
         
         	   ,serialization: {
         
         		  to: [$("#exTO"),$("#exFR")]
         
         		  ,resolution : 1
         
         	   }
         
         	});
         
         	
         
         	loadFormat();
         
         	
         
         	$('.noUiSlider div').bind('mouseup click',function(){
         
         		loadFormat();
         
         		$('#img_loading').show();
         
         		myVar = setInterval(function(){ filter() }, 2000);	
         
         	});
         
         	
         
         	$('.noUiSlider a').click(function(){
         
         		loadFormat();
         
         		$('#img_loading').show();
         
         		myVar = setInterval(function(){ filter() }, 2000);	
         
         	}); 
         
         	
         
         	$('.css-checkbox').click(function(){
         
         		if(!$(this).hasClass('disabled')) {
         
         			$('#img_loading').show();
         
         			myVar = setInterval(function(){ filter() }, 2000);
         
         		} else {
         
         			$('#img_loading').hide();
         
         			clearInterval(myVar);
         
         			return false;
         
         		}
         
         	});
         
         	$('#select_size').change(function(){
         
         		$('#img_loading').show();
         
         		myVar = setInterval(function(){ filter() }, 2000);	 
         
         	});
         
         	
         
         	$('.noUiSlider div').mousedown(function(){
         
         		clearInterval(myVar);
         
         	});
         
         	
         
         });
         
         
         
         function loadFormat() {
         
         	to = $("#exTO").val();
         
         	if(to.indexOf(",")&lt;0) {
         
         		$("#exTO").val(formatStr(to));
         
         	}
         
         	from = $("#exFR").val();
         
         	if(from.indexOf(",")&lt;0) {
         
         		$("#exFR").val(formatStr(from));
         
         	}
         
         }
         
         
         
         function formatStr(str) {
         
         	
         
         	str = str.toString();
         
         	strLast = str.substring(str.length-3, str.length);
         
         
         
         	abc = str.substring(0, str.length-3);
         
         
         
         	if(abc.length&gt;3) {
         
         		b = abc.substring(abc.length-3, abc.length);
         
         		c  = abc.substring(0, abc.length-3);
         
         		return c+","+b+","+strLast;
         
         	} else {
         
         		return abc+","+strLast;
         
         	}
         
         }
         
         
         
         function filter() {
         
         
         
         	clearInterval(myVar);
         
         	
         
         	location.href = url + 'san-pham/' + getUrlByValue();
         
         }
         
         
         
         function getUrlByValue() {
         
         	
         
         	/*type = "dem-lo-xo";*/
         
         	type = "loaidem";	
         
         	$('.from_type .css-checkbox').each(function(){
         
         		if($(this).attr('checked')=='checked') {
         
         			type += "-"+$(this).val();
         
         		}
         
         	});
         
         	
         
         	cate = "/hangsx";
         
         	$('.from_cate .css-checkbox').each(function(){
         
         		if($(this).attr('checked')=='checked') {
         
         			cate += "-"+$(this).val();
         
         		}
         
         	});
         
         	
         
         	
         
         	to = $("#exTO").val();
         
         	tos = "";
         
         	if(to.indexOf(",")&gt;=0) {
         
         		to = $("#exTO").val().split(",");
         
         		for(i=0;i&lt;to.length;i++) {
         
         			tos += to[i]; 
         
         		}
         
         	} else {
         
         		tos = to;
         
         	}
         
         	from = $("#exFR").val();
         
         	froms = "";
         
         	if(from.indexOf(",")&gt;=0) {
         
         		from = $("#exFR").val().split(",");
         
         		for(i=0;i&lt;from.length;i++) {
         
         			froms += from[i]; 
         
         		}
         
         	} else {
         
         		froms = from;
         
         	}
         
         	
         
         	price = "/"+tos+"-"+froms;
         
         	
         
         	size = "/"+$('#select_size').val();
         
         	
         
         	filter_url = type + cate + price + size;
         
         	return filter_url;
         
         }
         
                  var stateObj = { foo: "bar" };
                  
                  
                  
                  function test() {
                  
                  	history.pushState(stateObj, "page 1", "bar.html");
                  
                  }
                  
                  
                  
                  function filter_sub() {
                  
                  	
                  
                  	selfUrl = window.location.pathname;
                  
                  	c = selfUrl.indexOf("/san-pham");
                  
                  	d = selfUrl.indexOf("/tim-kiem");
                  
                  	
                  
                  	if(d&gt;=0) {
                  
                  		temp = selfUrl.split("/");
                  
                  		keyword = "&amp;keyword="+temp[3];
                  
                  		
                  
                  		order = "&amp;order="+$('.select_order').val();
                  
                  		show = "&amp;show="+$('.select_show').val();
                  
                  		
                  
                  		$.get(url+'?ajax=true&amp;mod=product'+keyword+order+show, function(rs){
                  
                  			$('.ajax_show_list').fadeOut(300, function(){
                  
                  				$('.ajax_show_list').html(rs);
                  
                  				$('.ajax_show_list').fadeIn(300);	
                  
                  			});
                  
                  		});
                  
                  		return;
                  
                  	}
                  
                  	if(c&lt;0) {
                  
                  		
                  
                  		temp = selfUrl.split("/");
                  
                  		
                  
                  		/* temp  = "/dem/acb/xyz"*/
                  
                  		type = "&amp;type="+temp[2];
                  
                  		cate = "";
                  
                  		if(temp[3]!=undefined) {
                  
                  			cate = "&amp;category="+temp[3];
                  
                  		}
                  
                  		order = "&amp;order="+$('.select_order').val();
                  
                  		show = "&amp;show="+$('.select_show').val();
                  
                  		
                  
                  		$.get(url+'?ajax=true&amp;mod=product'+type+cate+order+show, function(rs){
                  
                  			$('.ajax_show_list').fadeOut(300, function(){
                  
                  				$('.ajax_show_list').html(rs);
                  
                  				$('.ajax_show_list').fadeIn(300);	
                  
                  			});
                  
                  		});
                  
                  	} else {
                  
                  		temp = getUrlByValue().split("/");
                  
                  		
                  
                  		type = "&amp;type="+temp[0];
                  
                  		cate = "&amp;category="+temp[1];
                  
                  		price = "&amp;price="+temp[2];
                  
                  		size = "&amp;size="+temp[3];
                  
                  		
                  
                  		order = "&amp;order="+$('.select_order').val();
                  
                  		show = "&amp;show="+$('.select_show').val();
                  
                  		
                  
                  		$.get(url+'?ajax=true&amp;mod=product'+type+cate+price+size+order+show, function(rs){
                  
                  			$('.ajax_show_list').fadeOut(300, function(){
                  
                  				$('.ajax_show_list').html(rs);
                  
                  				$('.ajax_show_list').fadeIn(300);	
                  
                  			});
                  
                  		});		
                  
                  	
                  
                  	}
                  
                  }
                  

