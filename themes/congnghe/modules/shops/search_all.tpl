<!-- search -->
<!-- BEGIN: form -->
	<div class="title_page_right cyan">
		Kết quả tìm kiếm từ khóa :
		<span style="color:#f00; font-weight:bold; font-size:14px;">{value_keyword}</span>
	</div>
	<div id="msgshow" class="msgshow"></div>
<!-- END: form -->
<!-- BEGIN: main -->
	Tìm được  ({sa} sản phẩm)
	<div style="width: 788px;" class="pro_slide_list product_list">
    <ul class="home_list_slide">        
  	  <!-- BEGIN: items -->         
			<li style="border-bottom: 1px solid #bababa;width: 196px;">

				<!-- BEGIN: size -->     
					<h3 class="ul_li_title"><a style="font-size: 12px;" href="{LINK}">{TITLE0}</a></h3>
					<p class="ul_li_size"><a style="font-size: 12px;" href="{LINK}">{size}</a></p>
				<!-- END: size -->
				<!-- BEGIN: nosize -->
					<h3 class="ul_li_title2"><a style="font-size: 12px;" href="{LINK}">{TITLE0}</a></h3>
				<!-- END: nosize -->    
				<a class="link_product_list">
					<img alt="{TITLE0}" src="{IMG_SRC}" class="ul_li_image">
				</a>
				
					<!-- BEGIN: price -->     
					<p class="price1">Giá cũ: {product_price}</p>
					<span class="ul_li_code">(-{sale}%)</span>
					<span class="ul_li_price">Giá: {product_discounts}</span>
					<!-- END: price -->    
					<!-- BEGIN: price2 -->
					<p class="ul_li_price price3">Giá: {product_price}</p>
					<!-- END: price2 -->
					<!-- BEGIN: contact -->
					<p class="price4">Giá tham khảo: {product_price}</p>
					<p class="ul_li_price price2">Giá: Liên hệ</p>
					<!-- END: contact -->

          <div id="{id}" class="icons mua_hang" onclick="cartorder(this)"></div>
					
			</li>
			<!-- END: items -->     
			<div style="clear:left"></div>
			<div class="pages">
				{generate_page}    
			</div>
		</ul>
		<div class="pagination page-top">
		<ul class="paging clearfix"></ul>
	</div>
	<div style="clear:left"></div>
</div>      
<!-- END: main -->


