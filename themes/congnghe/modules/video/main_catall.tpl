<!-- BEGIN: main -->
<!-- BEGIN: cat -->
<div class="video_content_cate">
	<strong><a href="{CATE.link}">{CATE.title}</a></strong>
    <!-- BEGIN: subcat -->
    <span><a href="{SUB.link}">{SUB.title}</a></span>
    <!-- END: subcat -->
</div>
<div class="video_content clearfix">
	<!-- BEGIN: loop -->
    <div class="items">
    	<div class="content">
        	<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.img}"  width="120px" height="80px"/></a><br />
            <a href="{ROW.link}" title="{ROW.title}">{ROW.title1}</a><br />
            <span style="color:#666; font-size:11px">{LANG.view}</span>: <strong style="color:#F60;font-size:11px">{ROW.view}</strong>
            <div class="playicon" onclick="window.location='{ROW.link}'"></div>
        </div>
    </div>
    <!-- END: loop -->
</div>
<!-- END: cat -->
<!-- END: main -->