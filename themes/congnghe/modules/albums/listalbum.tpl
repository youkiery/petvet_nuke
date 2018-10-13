<!-- BEGIN: main -->
<div class="albums clearfix">
	<!-- BEGIN: loop -->
	<div class="items">
    	<a href="{ROW.link}" title="{ROW.title} {ROW.description} {ROW.add_time}" class="showimg"><img src="{ROW.img_small}" /></a>
        <p>{ROW.title1} <br />{LANG.view}:<strong>{ROW.view}</strong> </p>
    </div>
    <!-- END: loop -->
</div>
<!-- BEGIN: pages -->
<div class="pages">{htmlpage}</div>
<!-- END: pages -->
<!-- END: main -->