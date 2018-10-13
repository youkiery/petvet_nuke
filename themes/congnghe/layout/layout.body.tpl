<!-- BEGIN: main -->
{FILE "header.tpl"}

<div id="site">
<div class="clearfix bodymain">
       <!-- BEGIN: mod_title -->      
    <ul class="breadcrumbcate">
        <div >
            <a title="Trang chủ" href="{NV_BASE_SITEURL}" ><span >
                Trang chủ </span> </a>
        </div>
          <!-- BEGIN: breakcolumn -->
        <div ><a title="{BREAKCOLUMN.title}" href="{BREAKCOLUMN.link}" ><span >»  {BREAKCOLUMN.title}</span></a></div>
          <!-- END: breakcolumn -->
        
    </ul>
    <!-- END: mod_title --> 

    <div class="khung5">
        &nbsp;</div>
    <div id="col_right">
      {MODULE_CONTENT}
      </div>
    <div style="float: left;width: 242px;" id="sticky">
[RIGHT]

    </div>
    

        </div>
<script src='{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Scripts/tabs/easyResponsiveTabs.js'></script>
{FILE "footer.tpl"}
<!-- END: main -->

