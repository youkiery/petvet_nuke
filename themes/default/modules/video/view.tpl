<!-- BEGIN: main -->
<div class="video_content">
    <h3 style="margin:4px 0px; font-size:16px;">{DATA.title}</h3>
    <div style="border:1px solid #F8F8F8; background:#000; text-align:center; margin-bottom:10px">
    	<!-- BEGIN: file -->
		<script type='text/javascript' src='{NV_BASE_SITEURL}js/swfobject.js'></script>
        <div id='video'></div>
        <script type="text/javascript">	
            var movie = new SWFObject("{NV_BASE_SITEURL}images/jwplayer/player.swf","single","450","350","7"); 
            movie.addParam("allowfullscreen","true"); 
			movie.addParam("play","true");
			movie.addParam("wmode","transparent");
            movie.addVariable("file","{DATA.file_src}"); 
            movie.addVariable("image","{DATA.img}");  	
            movie.write("video"); 
        </script> 
        <!-- END: file -->
        <!-- BEGIN: embed -->
        {DATA.embed}
        <!-- END: embed -->
    </div>
    <!-- BEGIN: linko -->
    <h3>{LANG.otherlink}:</h3>
    <div style="padding:8px; margin-bottom:10px; background:#F8F8F8; border:#EAEAEA 1px solid"><a href="{DATA.otherpath}" target="_blank">{DATA.otherpath}</a></div>
    <!-- END: linko -->
    <p>{DATA.bodytext}</p>
</div>
<h2 style="margin-top:10px; margin-bottom:4px;">{LANG.otherfile}</h2>
<div class="video_content clearfix">
	<!-- BEGIN: loop -->
    <div class="items1">
    	<div class="content">
        	<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.img}"  width="120px" height="80px"/></a><br />
            <a href="{ROW.link}" title="{ROW.title}">{ROW.title1}</a><br />
            <span style="color:#666; font-size:11px">{LANG.view}</span>: <strong style="color:#F60;font-size:11px">{ROW.view}</strong>
            <div class="playicon" onclick="window.location='{ROW.link}'"></div>
        </div>
    </div>
    <!-- END: loop -->
</div>
<!-- END: main -->