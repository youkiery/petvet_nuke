<!-- BEGIN: main -->
<div class="pro_slide">
  <h3 class="pro_title"><i class="icons icons_arrow"></i>{TITLE_CATALOG}<a class="read_more" href="{LINK_CATALOG}" style="float:right">Xem thêm >></a></h3>
  <div class="pro_slide_list product_list">

    <ul id="mycarousel11" class="home_list_slide jcarousel-skin-tango11">
      <!-- BEGIN: loop --> 
      <li>
        <div class="tooltip">
          <h3>{title}</h3>
          <div class="content_tooltip">
            <!-- BEGIN: price1 -->  
            <!-- BEGIN: discounts1 -->
            <div class="price"><b>Giá bán:</b><b class="red"> {product_discounts} VNĐ</b></div>
            <!-- END: discounts1 -->
            <!-- END: price1 -->  
            <div class="summary"><b>Mô tả sản phẩm:</b>{hometext}</div>
          </div><!--content_tooltip-->
        </div><!--tooltip-->
        <h3 class="ul_li_title"><a style="font-size: 12px;" href="{link}">{title}</a></h3>
        <a class="link_product_list" href="{link}"><img class="ul_li_image" src="{src_img}" alt="{title}" /></a>

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
      <!-- END: loop -->  
    </ul>
  </div>
</div>
<!-- END: main -->