
<!-- BEGIN: main -->

      
      <h3 style="width: 205px;background: #1e3885;border-radius: 5px 5px 0px 0px;color: #fff;margin-bottom: 1px;" class="pro_title"><i class="icons icons_arrow"></i> {TITLE_CATALOG}</h3>
    
    <select style="float:right;margin: 0px 5px 10px 20px;" class="select_order" name="sort" id="sort" onchange=                          "changesort(this.value,'{OPST}','{view}')">
	                     <!-- BEGIN: sort -->
	               <option {select} value="{sort}">{value}</option>
                       <!-- END: sort -->
                        </select>
    <div class="compare-button"> </div>
    
    
    <div style="width: 788px;" class="pro_slide_list product_list">
      <ul class="home_list_slide">
        
         <!-- BEGIN: grid_rows -->     
        <li style="border-bottom: 1px solid #bababa;width: 196px;">
          <div class="tooltip" style="display: none;">
              <h3>{title_pro}</h3>
              <div class="content_tooltip">
               <!-- BEGIN: price1 -->  
                               <!-- BEGIN: discounts1 -->
                              <div class="price"><b>Giá bán:</b><b class="red"> {product_discounts} VNĐ</b></div>
                               <!-- END: discounts1 -->
                               <!-- END: price1 -->  
                <div class="summary"><b>Mô tả sản phẩm:</b>{intro}</div>
              </div><!--content_tooltip-->
            </div><!--tooltip-->
          
          <h3 class="ul_li_title"><a href="{link_pro}" style="font-size: 12px;">{title_pro0}</a></h3>
          <a href="{link_pro}" class="link_product_list"><img alt="{title_pro}" src="{img_pro}" class="ul_li_image"></a>
        
            <!-- BEGIN: price -->     
              <p class="{class_money}">Giá cũ: {product_price} VNĐ</p>
              <span class="ul_li_price">Giá: {product_discounts} VNĐ</span>
              <span class="ul_li_code">(-{sale}%)</span>
            <!-- END: price -->    
            <!-- BEGIN: price2 -->
              <p class="ul_li_price price2">Giá: {product_price} VNĐ</p>
            <!-- END: price2 -->
            <!-- BEGIN: contact -->
              <p class="ul_li_price price2">Giá: Liên hệ</p>
            <!-- END: contact -->
          
          <a class="icons mua_hang" href="javascript:void(0)" id="{id}"  onclick="cartorder_detail(this)" style="float:right;margin-right:59px;"></a>
        </li>
       <!-- END: grid_rows -->       

        
        </ul><div class="cls"></div>
        <div class="cls"></div>
      <div style="clear:left"></div>
     
         <div class="pages">
                {pages}    
                </div>
      
      
    </div>
    


<!-- END: main -->
