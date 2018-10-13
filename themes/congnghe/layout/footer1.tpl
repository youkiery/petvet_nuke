<script type="text/javascript">
			var eview = 0;
			function post_email(){
				var email = $('#subscribeEmail').val();
				$.ajax({
					type: 'POST',
					url: nv_siteroot + 'index.php?' + nv_lang_variable + '=' + nv_sitelang + '&' + nv_name_variable + '=shops&' + nv_fc_variable + '=regemail&emailsave=1&email='+email,
					data:'email='+email,
					success: function(data){
							$('#subscribeFormContent').html(data);
							}
				});
			}
			function action_email() { 
				if ( eview == 1 ) { $('#mail_content').slideUp('fast'); eview = 0; } 
				else { if ( eview == 0 ) { $('#mail_content').slideDown('fast'); eview = 1;  } }
			};
</script>
<div id="footer">
    [BANK]
    <div class="clearfix">
        <div class="fi_right">
[INFORMATION]
            
        </div>
    </div>
    <div class="fi_label">
        <div class="footer_head">
            <img class="icologof" width="16px" height="17px" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Themes/images/iconlogo.png"
                alt="Siêu thị điện máy" />
  [FOOTER1]
        </div>
        <div id="tag1">
            
            [FOOTER2]
            <div class="block-subscribe">    
    
        <div class="subscribe-content">
            <input type="text"  class="input-text"  id="subscribeEmail" name="email" placeholder="Nhập email để nhận tin khuyến mãi">
            <button class="button" title="Gửi" type="submit" onclick=" post_email()" ><span><span>&nbsp;</span></span></button>
        </div>        
 <div id="subscribeFormContent" style="color:#900; padding-top:45px;" align="center"></div>
 
</div>
        </div>
        
    </div>
    
 <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <noscript>
        <div style="display: inline;">
            <img height="1" width="1" style="border-style: none;" alt="" src="http://googleads.g.doubleclick.net/pagead/viewthroughconversion/982570312/?value=0&amp;guid=ON&amp;script=0" />
        </div>
    </noscript>

 <!-- BEGIN: for_admin -->
    <p class="show_query">
        {CLICK_SHOW_QUERIES}
    </p>
    <div id="div_hide" style="visibility: hidden; display: none;">
        {SHOW_QUERIES_FOR_ADMIN}
    </div>
    <!-- END: for_admin -->
    </div>
  {THEME_ADMIN_MENU}
{THEME_MY_FOOTER}
{THEME_FOOTER_JS} 
</body>

</html>
