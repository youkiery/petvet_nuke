<!-- BEGIN: main --> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="expires" content="0" />
        <meta name="resource-type" content="document" />
        <meta name="distribution" content="global" />
        <meta name="copyright" content="Copyright (c) {SITE_NAME}" />
        <meta name="robots" content="noindex, nofollow" />
        <title>{SITE_NAME} | {PAGE_TITLE}</title>
        <link rel="stylesheet" type="text/css" href="{CSS}" />
        <script type="text/javascript" src="{NV_BASE_SITEURL}js/language/{SITELANG}.js"></script>
        <script type="text/javascript">
            function nv_checkadminlogin_submit()
            {
               var password = document.getElementById( 'password' );
               if(password.value=='')
               {
            	   return false;
               }
               return true;
            } 

           function nv_admin_logout()
           {
              if (confirm(nv_admlogout_confirm[0]))
              {
            	  window.location.href = '{NV_BASE_SITEURL}index.php?second=admin_logout&ok=1';
              }
              return false;
           }
        </script>
        <!--[if IE 6]>
            <script src="{NV_BASE_SITEURL}js/fix-png-ie6.js"></script>
            <script>
            	DD_belatedPNG.fix('.submitform, img');
            </script>
        <![endif]-->
    </head>
    <body>
        <div style="border:1px solid #C9E4E4; width:400px; margin:auto; -moz-border-radius: 5px;
-webkit-border-radius: 5px;">
            <div class="logo_title"><span>{LOGIN_TITLE}</span></div>
            <div class="divform">
                <span class="info">{LOGIN_INFO}</span>
                <form class="loginform" method="post" onsubmit="return nv_checkadminlogin_submit();">
                    <ul>
                        <li>
                            <label>
                                {N_PASSWORD}:
                            </label>
                            <input name="nv_password" type="password" id="password" />
                        </li>
                    </ul>
                    <input name="redirect" value="{REDIRECT}" type="hidden"/>
                    <input name="save" id="save" type="hidden" value="1" />
                    <input class="submitform" type="submit" value="{N_SUBMIT}" />
                </form>
                <p align="right" style="padding:10px;">
                    <a class="lostpass" href="javascript:void(0);" onclick="nv_admin_logout();">{NV_LOGOUT}</a>
                </p>    
            </div>
        </div>
        <div style="border-top:#999 1px solid; padding-top:10px; margin-top:20px"></div>
        <p align="center">
            <strong>Welcome To Admin Of </strong>
            <a title="{SITE_NAME}" href="{NV_BASE_SITEURL}" style="text-decoration: none;"><strong style="color:#FF6600;">{SITE_NAME}</strong></a>. All rights reserved.
        </p>
    </body>
</html>
<!-- END: main -->
