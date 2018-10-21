<!-- BEGIN: main -->
<div id="products">
	<!-- BEGIN: catalogs -->
	<h3 class="pro_title z_viewlist">
		<i class="icons icons_arrow"></i>
		{TITLE_CATALOG}
	</h3>
	<div id="msgshow" class="msgshow"></div>
	<div class="compare-button"> </div>
		<section class="group-index-pro">
		<div style="width: 788px;" class="pro_slide_list product_list">
			<ul class="home_list_slide" id="thumb">
				<!-- BEGIN: items -->
        <li style="border-bottom: 1px solid #bababa;width: 196px;">
					<!-- BEGIN: size -->
						<h3 class="ul_li_title"><a style="font-size: 12px;" href="{link}">{title}</a></h3>
						<p class="ul_li_size"><a style="font-size: 12px;" href="{link}">{size}</a></p>
					<!-- END: size -->
					<!-- BEGIN: nosize -->
						<h3 class="ul_li_title2"><a style="font-size: 12px;" href="{link}">{title}</a></h3>
					<!-- END: nosize -->    

					<a class="link_product_list" href="{link}">
						<img class="ul_li_image" src="{img_src}" alt="{title}" />
					</a>

					<!-- BEGIN: price -->     
					<p class="price1">Giá cũ: {product_price} VNĐ</p>
					<span class="ul_li_code">(-{sale}%)</span>
					<span class="ul_li_price">Giá: {product_discounts} VNĐ</span>
					<!-- END: price -->    
					<!-- BEGIN: price2 -->
					<p class="ul_li_price price3">Giá: {product_price} VNĐ</p>
					<!-- END: price2 -->
					<!-- BEGIN: contact -->
					<p class="price4">Giá tham khảo: {product_price} VNĐ</p>
					<p class="ul_li_price price2">Giá: Liên hệ</p>
					<!-- END: contact -->

          <div id="{id}" class="icons mua_hang" onclick="cartorder(this)"></div>
				</li>
				<!-- END: items -->
			</ul>
		</aside>
	
	</section>
	<!-- END: catalogs -->
</div>
<div class="msgshow" id="msgshow"></div>
<!-- BEGIN: tooltip_js -->
<script type="text/javascript">
	tooltip_shop();

</script>
<!-- END: tooltip_js -->
<!-- END: main -->
