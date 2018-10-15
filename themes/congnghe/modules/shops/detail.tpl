<!-- BEGIN: main -->
	<link media="screen" type="text/css" rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/magiczoom.css">
	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/magiczoom.js"></script>

	<script type="text/javascript">
		MagicZoom.options = {
			'disable-zoom': false,
			'selectors-change': 'mouseover'
		}
	</script>
	<style type="text/css">
		/*zsize*/
		.size_box{
			display: inline-block;
			margin: 2px;
			padding: 0px 10px;
			text-align: center;
			border: 1px solid #0099FF;
			background: #5FABFF;
			border-radius: 8px;
			font-weight: bold;
			cursor: pointer;
		}
		.selected {
			border: 2px solid red;	
		}
		.size_name {
			font-weight: normal;
		}
		.size_price {
			color: white;
		}

		.jcarousel-skin-tango6 .jcarousel-prev.jcarousel-prev-horizontal {
			width: 30px !important;
			height: 40px !important;
			background: url(/includes/images/arr_left_thumnb.png) no-repeat;
			background-position: 8px 8px;
			top: 9px;
			left: -8px;
			position: absolute;
			cursor: pointer;
		}
		.jcarousel-skin-tango6 .jcarousel-next.jcarousel-next-horizontal {
			width: 30px !important;
			height: 40px !important;
			background: url(/includes/images/arr_right_thumnb.png) no-repeat;
			background-position: 16px 8px;
			top: 9px;
			right: 0px;
			position: absolute;
			cursor: pointer;
		}*/
	</style>
	<div id="pro_detail_top">
		<div id="pro_detail_images">
			<div id="pro_detail_img_zoom">
				<a title="" href="{SRC_PRO}" rel="selectors-effect-speed: 600" id="Zoomer" class="MagicZoom" style="margin: auto; display: inline-block; -moz-user-select: none; position: relative; text-decoration: none; outline: 0px none; width: 250px;"><img alt="{TITLE}" src="{SRC_PRO}" style="opacity: 1;"><div class="MagicZoomLoading" style="opacity: 0.75; display: none; overflow: hidden; position: absolute; visibility: hidden; z-index: 20; max-width: 246px; left: 73.5px; top: 112px;">Loading zoom..</div><div class="MagicZoomPup" style="z-index: 10; position: absolute; overflow: hidden; display: none; visibility: hidden; width: 186px; height: 171px; opacity: 0.5; left: 0px; top: 0px;"></div><div class="MagicZoomHint" style="display: block; overflow: hidden; position: absolute; visibility: visible; z-index: 1; left: 2px; right: auto; top: 2px; bottom: auto; opacity: 0.75; max-width: 246px;">Zoom</div></a>
			</div>

		</div>
		<div id="pro_detail_info">
			<h1 class="product_info_title">{TITLE}</h1>
			<div class="product_info_div_star">
				<!-- BEGIN: codesp -->
				<p style="float:left">Mã sp: {codesp}</p>
				<!-- END: codesp -->
			</div>
			<div class="product_info_div_star">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style" style="width: 387px;margin-top: -8px;float: left;position: relative;">
					<a fb:like:layout="button_count" class="addthis_button_facebook_like at300b"></a>
					<a class="addthis_button_tweet at300b"></a>
					<a g:plusone:size="medium" class="addthis_button_google_plusone at300b" style="position: relative;left: -26px;"></a>
					<a class="addthis_counter addthis_pill_style addthis_nonzero" style="position: relative; left: -46px; display: inline-block;" href="#"><a class="addthis_button_expanded" target="_blank" title="Thêm..." href="#" tabindex="1000">8</a></a>
					<div class="atclear"></div></div>
				<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-523824bb471c1b61" type="text/javascript"></script><div style="visibility: hidden; height: 1px; width: 1px; position: absolute; z-index: 100000;" id="_atssh"><iframe id="_atssh666" title="AddThis utility frame" style="height: 1px; width: 1px; position: absolute; z-index: 100000; border: 0px none; left: 0px; top: 0px;" src="//s7.addthis.com/static/r07/sh173.html#"></iframe></div><script type="text/javascript" src="http://s7.addthis.com/static/r07/core156.js"></script>
				<!-- AddThis Button END -->
			</div>
			<!-- BEGIN: price -->
			<p class="price1">Giá cũ: {product_price} VNĐ</p>
			<span class="product_info_price">Giá: {product_discounts} VNĐ</span>
			<span class="ul_li_code">(-{SALE})</span>
			<!-- END: price -->
			<!-- BEGIN: price2 -->
			<p class="product_info_price">Giá:  {product_price} VND</p>
			<!-- END: price2 -->
			<!-- BEGIN: contact -->
			<p style="font-weight:bold;">Giá tham khảo:</span> {product_price} VND</p>
			<p class="product_info_price">Giá: Liên hệ</p>
			<!-- END: contact -->
			<!-- BEGIN: size_prince -->
			{html_size}
			<p id="product_info_price" class="product_info_price">Size {size_min}, Giá {price_min} VND</p>
			<!-- END: size_prince -->

			<div class="cls"></div>
			<p>
				<a class="icons mua_hang" id="{proid}" title="{title_pro}"  onclick="cartorder_detail(this)" style="float:left;margin-right:5px; cursor: pointer;"></a>
			</p>
			<div class="cls"></div>
			<p id="msgshow" style="color: red"> </p>
			{detail_note2}

			<div class="product_info_km">
				<i class="icons icon_km_detail"></i>
				<!-- BEGIN: promotional -->
				<span class="red_km">Khuyến mãi:{promotional} </span>
				<!-- END: promotional -->
			</div>
		</div>
	</div>

	<div id="pro_detail_bottom">
		<script type="text/javascript">
			$(document).ready(function () {
				var c = $("ul.product_info_list_tab li a");
				var a = $(".info_flower_center_des__");
				a.hide();
				a.eq(0).show();
				c.click(function () {
					$val = $(this).attr("name");
					a.hide();
					$(".active").removeClass("active");
					$(this).addClass("active");
					a.eq($val).fadeIn();
					return false
				})
			});

		</script>
		<ul class="product_info_list_tab">
			<li><a class="active" name="0" href="">Mô tả sản phẩm</a></li>
			<li><a name="1" href="" class="">Khuyến mại chi tiết</a></li>
			<li><a name="2" href="" class="">Bản Đồ</a></li>
			<li><a name="3" href="" class="">Bình luận</a></li>
		</ul>
		<div class="info_flower_center_des__" style="display: block;">
			{DETAIL}
		</div>
		<div class="info_flower_center_des__" style="display: none;">
			{khuyenmaichitiet}
		</div>
		<div class="info_flower_center_des__" style="display: none;">
			<div class="maps">
				<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&language=vi"></script>
				<script type="text/javascript">
					// zsize
					function nv_change_size(size, price) {
						var size_elements = document.getElementsByClassName("size_box"), size_length = size_elements.length;
						for (var i = 0; i < size_length; i++) {
							size_elements[i].className = "size_box";
						}
						var size_element = document.getElementById('product_info_price');
						size_element.innerText = "Size " + size + ", Giá: " + price + " VND";
						var e = document.getElementById('size_box_' + size);
						e.className = "size_box selected";
					}

					function initialize() {
						var myLatLng = new google.maps.LatLng({maps});
						var mapOptions = {
							zoom: 16,
							center: myLatLng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
						var infowindow = new google.maps.InfoWindow({
							content: '<b>{businessname}</b><br /><br /><div style="width: 250px; height: 60px;">{businessdesc}</div>',
							position: myLatLng
						});
						infowindow.open(map);
						google.maps.event.addListener(map, 'zoom_changed', function () {
							var zoomLevel = map.getZoom();
							map.setCenter(myLatLng);
							infowindow.setContent('<b>{businessname}</b><br /><br /><div style="width: 250px; height: 60px;">{businessdesc}</div>');
						});
					}
					google.maps.event.addDomListener(window, 'load', initialize);
				</script>
				<div id="map-canvas" style=" height:300px; width:766px;"></div>
			</div>
		</div>
		<div class="info_flower_center_des__" style="display: none;">
			<!-- BEGIN: commentfb --><div class="fb-comments" data-href="{link_commentfb}" data-num-posts="5" data-width="766px"></div><!-- END: commentfb -->  
		</div>
	</div>

	<!-- BEGIN: other -->
	<div class="pro_detail_smiler">
		<h3 style="width: 205px;background: #1e3885;border-radius: 5px 5px 0px 0px;color: #fff;margin-bottom: 1px;" class="pro_title"><i class="icons icons_arrow"></i>{LANG.detail_others}</h3>
		<div class="cls"></div>
		<div style="width:788px;border-bottom:2px solid #1e3885;"></div>
		<div style="width: 788px;overflow: hidden;margin-top: 5px" class="pro_slide_list">
			<div class=" jcarousel-skin-tango8"><div class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block;"><div class="jcarousel-clip jcarousel-clip-horizontal" style="position: relative;"> {OTHER}</div><div class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal" style="display: block;" disabled="disabled"></div><div class="jcarousel-next jcarousel-next-horizontal" style="display: block;"></div></div></div>
		</div>
	</div>
	<!-- END: other -->
<!-- END: main -->
