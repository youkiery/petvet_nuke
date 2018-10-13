<!-- BEGIN: main -->
<style type="text/css">
.block_video_new {
	border:1px solid #F4F4F4;
	padding:5px;
	background:#F9F9F9;
	height:255px;
	position:relative
}
.block_video_new p{
	margin:0;
}
.playiconn {
	position:absolute;
	top:100px;
	left:120px;
	display:inline-block;
	background:url('{NV_BASE_SITEURL}themes/{THEME}/images/video/play-icon.png') no-repeat;
	height:48px;
	width:48px;
	cursor:pointer;
}
</style>
<div class="block_video_new">
    <strong><a href="{ROW.link}" title="{ROW.title}">{ROW.title1}</a></strong>
    <span style="color:#666; font-size:11px">(video) {LANG.view}</span>: <strong style="color:#F60;font-size:11px">{ROW.view}</strong>
    <div align="center" style="margin:3px 0px">
         <a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.src}" width="275px" height="160px"/></a>
    </div>     
    <p align="justify" style="color:#333; font-size:11px">{ROW.hometext}</p>
    <div class="playiconn" onclick="window.location='{ROW.link}'"></div>
</div>
<!-- END: main -->