
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" itemscope itemtype="http://schema.org/Product">
<head id="ctl00_header">
        {THEME_PAGE_TITLE}
      {THEME_META_TAGS}
      <link rel="icon" href="{NV_BASE_SITEURL}favicon.ico" type="image/vnd.microsoft.icon" />
      <link rel="shortcut icon" href="{NV_BASE_SITEURL}favicon.ico" type="image/vnd.microsoft.icon" />
      <link rel="stylesheet" type="text/css" media="screen" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/icons.css" />
     {THEME_CSS} 
     {THEME_SITE_RSS}
     {THEME_SITE_JS}
     <link rel="Stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Style/style.css" /> 
       <link rel="Stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Style/popbox.css" /> 
    <script src='{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Scripts/libs2.js'></script>
    <script src='{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Scripts/stickytooltip.js'></script>
    <script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Scripts/jquery.cycle.all.min.js"></script>
    
    <script src='{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Scripts/jquery.tabs.js'></script>
    


    <script type="text/javascript">
 



        $(document).ready(function () {
            $('#tag').easyResponsiveTabs({
                type: 'vertical',
                width: 'auto',
                fit: true
            });
        });

        $(document).ready(function ($) {
            

            $('#slideshow').cycle({
                fx: 'fade',
                timeout: 4000,
                pager: '#spotlightnav',
                pagerAnchorBuilder: function (idx, slide) {
                    idx++;
                    return '<li><a href="#">' + idx + '</a></li>';
                }
            });
        });



    </script>
     
<script>
var $stickyHeight = 250;
var $padding = 0;
var $topOffset = 400;
var $footerHeight = 410;
/* <![CDATA[ */
function scrollSticky(){
if($(window).height() >= $stickyHeight) {
var aOffset = $('#sticky').offset();
if($(document).height() - $footerHeight - $padding < $(window).scrollTop() + $stickyHeight) {
var $top = $(document).height() - $stickyHeight - $footerHeight - $padding - 800;
$('#sticky').attr('style', '');
}else if($(window).scrollTop() + $padding > $topOffset) {
$('#sticky').attr('style', 'position:fixed; right:76px; float: left;width: 242px; top:'+$padding+'px;');
}else{
$('#sticky').attr('style', '');
}
}
}
$(window).scroll(function(){
scrollSticky();
});
/* ]]> */
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</head>
<body id="ctl00_pone" >


<script type="text/javascript">
//<![CDATA[
var theForm = document.forms['aspnetForm'];
if (!theForm) {
    theForm = document.aspnetForm;
}
function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
        theForm.__EVENTTARGET.value = eventTarget;
        theForm.__EVENTARGUMENT.value = eventArgument;
        theForm.submit();
    }
}
//]]>
</script>

<div id="outer">
    <div id="header">
        <div class="header clearfix">
            <div class="logo">
                <a href="{NV_BASE_SITEURL}" title="{THEME_LOGO_TITLE}">
                    <img alt="{THEME_LOGO_TITLE}" src="{LOGO_SRC}" />
                </a>
            </div>
            <ul class="page_reg">
   
                <li class="page_list2">
                    [TOP]
                    
                </li>
            </ul>
            <div class="top_banner">
                
                        [BANNER-HEADER]
                    
            </div>
        </div>
    </div>
</div>

<div id="bottombar">
    <div class="bb_open clearfix" style="display: none">
        <marquee behavior="alternate" style="width: 275px;">
        <a href="khuyenmai.html" style="color:#fff;text-decoration:none;font-weight:bold;display:inline;margin-top:4px;float:left">
        <img class="icologobottom" width="16px" height="17px" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/Themes/images/iconlogo.png" alt="Siêu thị điện máy">
        [HTML-HOLINE-BOTTOM]</a></marquee>
        <a href="javascript://" onclick="toggle_bb();">
            <img width="21" height="23" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/images/open_popup.ico" style="float: right"
                border="0" alt="Mua hàng Online " /></a>
    </div>
    <div class="bb_close clearfix">
    
        <a href="javascript://" id="closebb" onclick="toggle_bb();">x</a>
        <div class="popup-bottom">
        [POPUP_BOTTOM]
        </div>
    </div>
    
    
</div>




<div class="slideR">
    <span id="slideR"></span>
</div>





<script type="text/javascript">
    
     var bannerArrayslideR = new Array();
    var currentImageslideR = 0;
        bannerArrayslideR = [];
    function getRandomslideR() {
        if(bannerArrayslideR.length>0){
             var bannerHolderslideR = document.getElementById('slideR');
             bannerHolderslideR.innerHTML =   bannerArrayslideR[currentImageslideR];
             if (currentImageslideR < bannerArrayslideR.length - 1) {
                 currentImageslideR += 1;
             } else {
                 currentImageslideR = 0;
                }
            }}
    getRandomslideR();
   

    var ispopup = '1';
    var _pathP = window.location.pathname; 
    if ((_pathP == "/default.aspx") || (_pathP == "/index.htm") || (_pathP == "/") || (_pathP == "/Default.aspx")) 
    { 
    if (ispopup == '1')$(function () {$.colorbox({ inline: true, escKey:true,title: true,width: 688, height: 510, href: "#inline_advPopup" ,onClosed:function() { $.colorbox.remove();} }); });
    
    window.setTimeout(function() {$.colorbox.close();}, 10000);

    }
                 

    var bannerArrayHomeCenter29 = new Array();
    var currentImageHomeCenter29 = 0;
        bannerArrayHomeCenter29 = ['<a target="_blank"  href="http://trananh.vn/khuyenmai.htm"><img alt="Mua hàng Online 1900 545 546 - ext1" width="378px" height="208px" border="0" src="http://adv.trananh.vn/trananh/2014/07/31/378x208.png" /></a>'];
    function getRandomNumHomeCenter29() {
        if(bannerArrayHomeCenter29.length>0){
             var bannerHolderHomeCenter29 = document.getElementById('bannerHolderHomeCenter29');
             bannerHolderHomeCenter29.innerHTML =   bannerArrayHomeCenter29[currentImageHomeCenter29];
             if (currentImageHomeCenter29 < bannerArrayHomeCenter29.length - 1) {
                 currentImageHomeCenter29 += 1;
             } else {
                 currentImageHomeCenter29 = 0;
                }
            }}
    getRandomNumHomeCenter29();

    window.setTimeout(function() { closebb(); }, 20000);



    var _path29 = window.location.pathname;
    if ((_path29 == "/default.aspx") || (_path29 == "/index.htm") || (_path29 == "/") || (_path29 == "/Default.aspx"))
    {
                                        
    }
    else
    { 
    closebb();                  
    }
    if (ispopup == '0')  closebb(); 
    function closebb() {  $('#closebb').click(); } 




    function isNumberKey(evt) {
        if (window.event) {
            var key = evt.keyCode;
        }
        else {
            var key = evt.which;
        }
        if (key == 8 || key == 46
     || key == 37 || key == 39) {
            return true;
        }
        else if (key < 48 || key > 57) {
            return false;
        }
        else return true;
    }


    function toggle_bb() {
        if ($(".bb_open").css('display') == 'none') {
            $(".bb_open").show();
            $(".bb_close").hide();
            $(".bottombar").toggle();
        }
        else if ($(".bb_close").css('display') == 'none') {
            $(".bb_open").hide();
            $(".bb_close").show();
            $(".bottombar").toggle();
        }
    }

    function toggle_bbL() {
        if ($(".bb_openL").css('display') == 'none') {
            $(".bb_openL").show();
            $(".bb_closeL").hide();
            $(".bottombarL").toggle();
        } else if ($(".bb_closeL").css('display') == 'none') {
            $(".bb_openL").hide();
            $(".bb_closeL").show();
            $(".bottombarL").toggle();
        }

    }
    
    var bannerArrayHomeCenterBL = new Array();
            var currentImageHomeCenterBL = 0;
            bannerArrayHomeCenterBL = [];
            function getRandomNumHomeCenterBL() {
                if(bannerArrayHomeCenterBL.length>0){
                    var bannerHolderHomeCenterBL = document.getElementById('bannerHolderHomeCenterBL');
                    bannerHolderHomeCenterBL.innerHTML =   bannerArrayHomeCenterBL[currentImageHomeCenterBL];
                    if (currentImageHomeCenterBL < bannerArrayHomeCenterBL.length - 1) {
                        currentImageHomeCenterBL += 1;
                    } else {
                        currentImageHomeCenterBL = 0;
                    }
                }}
    getRandomNumHomeCenterBL();
    window.setTimeout(function() { closebbL(); }, 10000);

    var _path = window.location.pathname;
    if ((_path == "/default.aspx") || (_path == "/index.htm") || (_path == "/") || (_path == "/Default.aspx")) {  }
    else
    { 
    closebb();                  
    }
    if (ispopup == '0')  closebbL(); 
    function closebbL() { $('#closebbL').click(); }   



    function CheckKeyword() {
        if (document.getElementById("ctl00_topbar1_txtKeyword").value == "" || document.getElementById("ctl00_topbar1_txtKeyword").value == "Từ khóa tìm kiếm") {
            alert("Hãy nhập từ khóa tìm kiếm");
            return false;
        }
        else {
            return true;
        }

    }
    function SearchOnFocus(field) {
        if (field.value == 'Từ khóa tìm kiếm') { field.value = ''; }
    }

    function SearchOnBlur(field) {
        if (field.value == '') { field.value = 'Từ khóa tìm kiếm'; }
    }



     function open_me(url, vStatus, vResizeable, vScrollbars, vToolbar, vLocation, vFullscreen, vTitlebar, vCentered, vHeight, vWidth, vTop, vLeft) {
            winDef = '';
            winDef = winDef.concat('status=').concat((vStatus) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('resizable=').concat((vResizeable) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('scrollbars=').concat((vScrollbars) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('toolbar=').concat((vToolbar) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('location=').concat((vLocation) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('fullscreen=').concat((vFullscreen) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('titlebar=').concat((vTitlebar) ? 'yes' : 'no').concat(',');
            winDef = winDef.concat('height=').concat(vHeight).concat(',');
            winDef = winDef.concat('width=').concat(vWidth).concat(',');

            if (vCentered) {
                winDef = winDef.concat('top=').concat((screen.height - vHeight) / 2).concat(',');
                winDef = winDef.concat('left=').concat((screen.width - vWidth) / 2);
            }
            else {
                winDef = winDef.concat('top=').concat(vTop).concat(',');
                winDef = winDef.concat('left=').concat(vLeft);
            }

            open(url, '_blank', winDef);
            return false;
        }


      




</script>

<div class="menu">
    <ul class="ls menu-hori">
        [MENU_NAV]
        <li>
            <div class="tb_bar">
                <!-- Search start -->

                [SEARCH]
                <!-- Search end -->
                [SUPPORT]
                [HOTLINE]
            </div>
        </li>
    </ul>
</div>