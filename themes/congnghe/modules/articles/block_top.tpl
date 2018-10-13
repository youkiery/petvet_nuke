<!-- BEGIN: main -->
<style type="text/css">
.items_content{ 
}
.items_content .time{ color:#666666 }
.items_content a{
	font-weight:bold;
}
.items_content a img{ 
	float:left; margin-right:5px;
	border:1px solid #F8F8F8; padding:1px;
}
</style>
<div class="items_content">
    <!-- BEGIN: img --><a href="{ROW.link}"><img src="{ROW.src}" /></a><!-- END: img -->
    <span class="title"><a href="{ROW.link}">{ROW.title}</a></span>
    <p align="justify">{ROW.hometext}</p>
    <span class="time">{LANG.update} : {ROW.add_time}</span>
</div>
<!-- END: main -->