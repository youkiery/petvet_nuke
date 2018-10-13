<!-- BEGIN: main -->
<div class="articles_detail">
    <h2>{DATA.title}</h2>
    <p class="time">
    	<span>{LANG.add_time} : {DATA.add_time}</span>
        <span class="addthis_toolbox addthis_default_style">
            <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4ce559316ab72048" class="addthis_button_compact">Share</a>
            <span class="addthis_separator">|</span>
            <a class="addthis_button_preferred_1"></a><a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a><a class="addthis_button_preferred_4"></a>
        </span>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4ce559316ab72048"></script>
    </p>
    
    <!-- BEGIN: hometext -->
    <div class="hometext clearfix"><strong>{DATA.hometext}</strong></div>
    <!-- END: hometext -->
    
    <p>{DATA.bodytext}</p>    
    <p>
        <!-- BEGIN: author --> 
        {LANG.author} : <b>{DATA.author}</b> -
        <!-- END: author -->
        <!-- BEGIN: source --> 
        {LANG.source} : <b>{DATA.source}</b>
        <!-- END: source -->
        <!-- BEGIN: admin_link --> 
        {admin_link}
        <!-- END: admin_link -->
        <br /><span class="time">{LANG.edit_time} : {DATA.edit_time}</span>
    </p>
        
    <!-- BEGIN: keywords -->
    <div class="articles_keywords">
    	<strong>{LANG.tags} :</strong>
        <!-- BEGIN: loop -->
        <a href="javascript:void(0)" title="{KEY.title}" onclick="nv_key_search_click('{KEY.title}','{KEY.ck}')">{KEY.title}</a>
        <!-- END: loop -->
    </div>
    <!-- END: keywords -->
    
    <!-- BEGIN: comment -->
    <div class="articles_showcomment">
        <div id="showcomment"></div>
        <form action="" method="post" class="articles_formcomment">
        <input type="hidden" value="{DATA.id}" id="articlesid" />
    	<h3>{LANG.comment_send_title} : </h3>
    	<p class="clearfix">
        	<input type="text" id="idname" value="{LANG.fullname}" class="fl" style="width:40%;margin-right:2px"/>
            <input type="text" id="idemail" value="{LANG.email}" class="fl" style="width:50%"/>
        </p>
        <p>
        	<textarea style="height:80px; width:99%" id="idcontent">{LANG.content}</textarea>
        </p>
        <p class="clearfix">
            <input type="text" id="seccode" class="fl" value="{LANG.commentseccode}"/>
            <img id="vimg" src="{SRC_CAPTCHA}" style="height:21px; cursor:pointer" class="fl" onclick="nv_change_captcha('vimg','seccode');"/>
            <input type="button" id="comment_submit" class="fr" value="{LANG.comment_submit}" onclick="sendcommment('{DATA.id}','{DATA.ck}');"/>
            <input type="reset" class="fr" value="{LANG.comment_reset}"/>
        </p>
        </form>
    </div>
    <script type="text/javascript">
    clearinputtxt('idname','{LANG.fullname}');clearinputtxt('idemail','{LANG.email}');clearinputtxt('idcontent','{LANG.content}');
	clearinputtxt('seccode','{LANG.commentseccode}'); nv_commment_show();
    </script>
    <!-- END: comment -->
    
    <!-- BEGIN: other -->
    <div class="articles_other">
        <h3>{LANG.others} : </h3>
        <ul>
            <!-- BEGIN: loop -->
            <li><a href="{OTHER.link}" title="{OTHER.title}">{OTHER.title}</a></li>
            <!-- END: loop -->
        </ul>
    </div>
    <!-- END: other -->
</div>
<!-- END: main -->