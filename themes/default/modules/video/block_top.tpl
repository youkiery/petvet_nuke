<!-- BEGIN: main -->
<style type="text/css">
.block_video {
}
.b_items_content{ 
	position:relative;
	margin-bottom:8px;
}
.b_items_content .time{ color:#666666 }
.b_items_content a{
	color:#069;
	font-size:8pt;
	font-family:Tahoma;
}
.b_items_content a:hover{
	color:#930
}
.b_items_content img.class1{ 
	float:left; margin-right:5px;
	border:1px solid #F8F8F8; 
	padding:2px;
	background:#FFF;
	width:60px;
	height:40px
}
.b_items_content img.class2{ 
	border:1px solid #F8F8F8; 
	padding:2px;
	background:#FFF;
	width:160px;
}
</style>
<ul class="block_video">
<!-- BEGIN: loop1 -->
<li class="b_items_content clearfix">
    <!-- BEGIN: img -->
    <div align="center">
    	<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.src}" class="class2"/></a>
    </div>    
    <!-- END: img -->
    <a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a>
    <p style="color:#666; font-size:11px">
    	<span style="color:#666; font-size:11px">view</span>: <strong style="color:#F60;font-size:11px">{ROW.view}</strong>
    	{ROW.hometext}
    </p>
</li>
<!-- END: loop1 -->
<!-- BEGIN: loop -->
<li class="b_items_content clearfix">
    <!-- BEGIN: img --><a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.src}" class="class1"/></a><!-- END: img -->
    <span style="color:#666; font-size:11px">view</span>: <strong style="color:#F60;font-size:11px">{ROW.view}</strong>
    <a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a>
</li>
<!-- END: loop -->
</ul>
<!-- END: main -->