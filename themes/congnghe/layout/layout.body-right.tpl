<!-- BEGIN: main -->
{FILE "header.tpl"}
<div style="margin-top: 3px;" id="content">
   <!-- BEGIN: mod_title -->    
  <div class="cate_link">
    <a href="{NV_BASE_SITEURL}">Trang chủ</a>
     <!-- BEGIN: breakcolumn -->
     / <a href=""></a><a href="{BREAKCOLUMN.link}">{BREAKCOLUMN.title}</a> 
      <!-- END: breakcolumn -->
  </div>
     <!-- END: mod_title -->    
  
<div id="content_left">
  [DANHMUC]
  
  
  <div style="padding-bottom: 15px;" class="content_left_top1">
    <h3 class="left_top1_title">Bộ lọc sản phẩm</h3>
    [BOLOC] 
  </div> 
</div>
<div style="width: 788px;padding:0px 0px;border: none;" id="content_right">
 {MODULE_CONTENT}
</div>
 
</div>
{FILE "footer.tpl"}
<!-- END: main -->

