<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}modules/{MODULE_NAME}/js/colorbox/colorbox.css" />
<script src="{NV_BASE_SITEURL}modules/{MODULE_NAME}/js/colorbox/jquery.colorbox.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	//Examples of how to assign the ColorBox event to elements
	$(".showimg").colorbox({rel:'showimg'});
});
</script>			
<div class="albums clearfix">
	<!-- BEGIN: loop -->
	<div class="items">
    	<a href="{ROW.img}" title="{ROW.title} {ROW.description} {ROW.addtime}" class="showimg"><img src="{ROW.img_small}" /></a>
        <p>{ROW.title1}</p>
        <p><a href="{ROW.link}">{ROW.album_name} ({ROW.numitems})</a></p>
    </div>
    <!-- END: loop -->
</div>
<!-- BEGIN: pages -->
<div class="pages">{htmlpage}</div>
<!-- END: pages -->
<!-- END: main -->