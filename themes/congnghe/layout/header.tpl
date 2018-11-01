<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
      {THEME_PAGE_TITLE}
      {THEME_META_TAGS}
      <link rel="icon" href="{NV_BASE_SITEURL}favicon.ico" type="image/vnd.microsoft.icon" />
      <link rel="shortcut icon" href="{NV_BASE_SITEURL}favicon.ico" type="image/vnd.microsoft.icon" />
      <link rel="stylesheet" type="text/css" media="screen" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/icons.css" />
     {THEME_CSS} 
     {THEME_SITE_RSS}
     {THEME_SITE_JS}
    <link href="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/style.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/jquery.min.js"></script>
    <script type="text/javascript" src="{NV_BASE_SITEURL}js/jquery/jquery.ui.min.js"></script>

  	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/p_tooltip.js"></script>
  	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/js/common.js"></script>
    <script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/js/swfobject.js"></script>
  	
  	<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/skin.css" type="text/css" />
	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/jquery.jcarousel.min.js"></script>
  	<!--script type="text/javascript" src="/{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/jqueryEasing.js"></script-->
  	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/includes/tpl_script/mycarousel_fun.js"></script>
  	
    
    <script type="text/javascript">
      $(window).scroll(function(){
      t = parseInt($(window).scrollTop());
      
      if(t < 100) $('#banner_left_scroll,#banner_right_scroll').stop().animate({marginTop:t},500,"easeOutBack");
      else $('#banner_left_scroll,#banner_right_scroll').stop().animate({marginTop:t},500,"easeOutBack");
      })
    </script> 
  
    <script type="text/javascript">
      document.write('<div id="fb-root"></div>');
      (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "../connect.facebook.net/vi_VN/all.js#xfbml=1&appId=199828456846777";
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
  <script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '../connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '759339034087077']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=759339034087077&amp;ev=NoScript" /></noscript>
 {THEME_MY_HEAD}
</head>
  <style type="text/css">
	body {
    width: 100%;
    height: 230px;
    z-index: -1;
    background: #fff url(/themes/congnghe/site_code/bg_bg_bg_new2.jpg) center top;
    position: absolute;
    background-size: cover;
    background-repeat-x: repeat;
    background-repeat-y: no-repeat;
	}
  </style>
<body>
  <div class="main_bg">
    <div class="wrap"></div>
	<div class="main">
      
      <div id="banner_left_scroll">
        
        [BANNER_LEFT]
        
      </div>
      <div id="banner_right_scroll">
        <div style="clear:both" class="cls"></div>
        
        	 [BANNER_RIGHT]
        
       
      </div>
      
    	<div id="header">
        	<div id="header_left">
            	<div id="header_logo">

                  <a href="{NV_BASE_SITEURL}"><img src="{LOGO_SRC}" alt="{THEME_LOGO_TITLE}" /></a>
                </div>
            </div>
            <div id="header_right">
            	<div id="header_right_top">
                	<ul>
                     
                      [TOP]
                	</ul>
                </div>
                <div id="header_right_mid">
                	[HOTLINE]
                    <div id="right_mid_right">
                      [CART]
                        [SEARCH]
                    </div>
                </div>
                [SUPPORT]
            </div>
        </div><!--end header-->
        [MENU_NAV]<!--end menu-->