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
<div id="footer" style="clear:left;background:#fff">
  [SLIDER_FOOTER]
  <div class="cls"></div>
  <div class="pro_slide list_new_home">
   [NEWS]
    
   
  </div><!--end pro_slide-->
  <div class="cls"></div>
  <!--end pro_slide-->
  <div class="cls"></div>
  <div class="pro_slide info_footer">
    <div class="cls"></div>
    <div id="footer_left">
      <div id="footer_left_top">
        [FOOTER_MENU]

      </div><!--end footer_left_top-->
      <div id="footer_left_bottom">
  <a id="subscribeFormContent" style="color:#900; " align="center"></a>
        <div id="footer_submail" style="margin: 17px 0px 0px 20px;">
          <span class="icons sub_mail"></span><span class="black" style="position:relative;top:-2px;font-weight:bold;width:90px;">Nhận báo giá</span>   
          <div class="sum_email icons">
            
              <input id="subscribeEmail" name="email" type="text" placeholder="Nhập email" class="txt_mail" />
              <a onclick=" post_email()" class="txt_submail" >
          
          </div>
           
            [SHARE]
   
        </div>
        <div id="footer_connect"></div>
      </div><!--end footer_left_bottom-->
    </div><!--end footer_left-->
    <div id="footer_right" style="position: relative;">
[HTML_FOOTER]
      <div id="footer_traffic">
          
            <a href="http://www.alexa.com/siteinfo/http://megacode.vn/"><script type='text/javascript' src='http://xslt.alexa.com/site_stats/js/t/a?url=http://megacode.vn/'></script></a>
            <!-- Histats.com  START  (standard)-->
           
        </div>
      
    </div><!--end footer_right-->
  </div><!--end pro_slide-->
</div>
</div><!--end main-->
  
  
<!--POPUP FOOTER- Bo & them quang cao duoi-->
<!--
<div id="fl813691" style="height: 152px;">
<div id="eb951855">
<div id="cob263512">
<div id="coh963846">
<ul id="coc67178">
<li id="pf204652hide"><a class="min" href="javascript:pf204652clickhide();" title="An">An</a></li>
<li id="pf204652show" style="display: none;"><a class="max" href="javascript:pf204652clickshow();" title="Hien">Xem </a></li>
</ul>
</div>
<div id="co453569">
[POPUP_FOOTER]
-->
<!-- code ads -->
</div>
</div></div></div>
  
  <script type="text/javascript">
    pf204652bottomLayer = document.getElementById('fl813691');
    var pf204652IntervalId = 0;
    var pf204652maxHeight = 110;//Chieu cao khung quang cao
    var pf204652minHeight = 20;
    var pf204652curHeight = 0;
    function pf204652show(){
    pf204652curHeight += 2;
    if(pf204652curHeight > pf204652maxHeight){
    clearInterval(pf204652IntervalId);
    }
    pf204652bottomLayer.style.height = pf204652curHeight+'px';
    }
    function pf204652hide(){
    pf204652curHeight -= 3;
    if(pf204652curHeight < pf204652minHeight){
    clearInterval(pf204652IntervalId);
    }
    pf204652bottomLayer.style.height=pf204652curHeight+'px';
    }
    pf204652IntervalId=setInterval('pf204652show()',5);
    function pf204652clickhide(){
    document.getElementById('pf204652hide').style.display='none';
    document.getElementById('pf204652show').style.display='inline';
    pf204652IntervalId=setInterval('pf204652hide()',5);
    }
    function pf204652clickshow(){
    document.getElementById('pf204652hide').style.display='inline';
    document.getElementById('pf204652show').style.display='none';
    pf204652IntervalId=setInterval('pf204652show()',5);
    }
    function pf204652clickclose(){
    document.body.style.marginBottom = '0px';
    pf204652bottomLayer.style.display = 'none';
    }
  </script>


  
  
</div><!--end main_bg-->
<script type="text/javascript">
  
  var _gaq = _gaq || [];
  var pluginUrl =
  'http://google-analytics.com/plugins/ga/inpage_linkid.js';
  _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
  _gaq.push(['_setAccount', 'UA-15557748-12']);
  _gaq.push(['_trackPageview']);
  
  (function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
</script>

<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','http://google-analytics.com/analytics.js','ga');
  
  ga('create', 'UA-20674394-3', 'cameramienbac.com.vn');
  ga('send', 'pageview');
  
</script>


 <!-- BEGIN: for_admin -->
    <p class="show_query">
        {CLICK_SHOW_QUERIES}
    </p>
    <div id="div_hide" style="visibility: hidden; display: none;">
        {SHOW_QUERIES_FOR_ADMIN}
    </div>
    <!-- END: for_admin -->
      {THEME_ADMIN_MENU}
{THEME_MY_FOOTER}
{THEME_FOOTER_JS} 
</body>
</html>
