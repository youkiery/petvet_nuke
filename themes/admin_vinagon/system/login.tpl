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
        <link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{ADMIN_THEME}/css/login.css" />
        <script type="text/javascript">
            var jsi = new Array('{SITELANG}', '{NV_BASE_SITEURL}', '{CHECK_SC}', '{GFX_NUM}');
            <!-- BEGIN: jscaptcha -->
            	var login_error_security = '{LOGIN_ERROR_SECURITY}';
            <!-- END: jscaptcha -->
        </script>
        <script type="text/javascript" src="{NV_BASE_SITEURL}js/admin_login.js"></script>
        <!--[if IE 6]>
            <script type="text/javascript" src="{NV_BASE_SITEURL}js/fix-png-ie6.js"></script>
            <script type="text/javascript">
            DD_belatedPNG.fix('#');
            </script>
        <![endif]-->
    </head>
    <body>
        <div style="border:1px solid #C9E4E4; width:400px; margin:auto; -moz-border-radius: 5px;
-webkit-border-radius: 5px;">
        	<div class="logo_title"><span>{LOGIN_TITLE}</span></div>
            <div class="divform">
                <span class="info">{LOGIN_INFO}</span>
                <form class="loginform" method="post" action="{NV_BASE_ADMINURL}index.php" onsubmit="return nv_checkadminlogin_submit();">
                    <ul>
                        <!-- BEGIN: lang_multi -->
                        <li>
                            <label>{LANGTITLE}:</label>
                            <select id="langinterface" name="langinterface" onchange="top.location.href=this.options[this.selectedIndex].value;">
                                <!-- BEGIN: option -->
                                    <option value="{LANGOP}" {SELECTED}>{LANGVALUE}  </option>
                                <!-- END: option -->
                            </select>
                        </li>
                        <!-- END: lang_multi -->
                        <li>
                            <label>{N_LOGIN}:</label>
                            <input name="nv_login" type="text" id="login" value="{V_LOGIN}" maxlength="{NICKMAX}" style="width:150px" />
                        </li>
                        <li>
                            <label>{N_PASSWORD}:</label>
                            <input name="nv_password" type="password" id="password" maxlength="{PASSMAX}" style="width:150px"/>
                        </li>
                        <!-- BEGIN: captcha -->
                        <li>
                            <label>{N_CAPTCHA}:</label>
                            <input name="nv_seccode" type="text" id="seccode" maxlength="{GFX_NUM}" style="width:60px;"/><img id="vimg" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" src="{NV_BASE_SITEURL}index.php?scaptcha=captcha" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" /><img alt="{CAPTCHA_REFRESH}" title="{CAPTCHA_REFRESH}" src="{CAPTCHA_REFR_SRC}" width="16" height="16" class="refresh" onclick="nv_change_captcha();"/>
                        </li><!-- END: captcha -->
                    </ul>
                    <p style="text-align:center">
                        <input type="submit" value="{N_SUBMIT}" />
                        <input type="reset" value="Format"/>
                        <div style="padding:5px; text-align:center">
                            <a class="lostpass" title="{LANGLOSTPASS}" href="{LINKLOSTPASS}">{LANGLOSTPASS}?</a> |
                            <a class="lostpass" title="Home page" href="{NV_BASE_SITEURL}">Home page</a>
                        </div>
                    </p>
                </form>
            </div>
        </div>

        <div style="border-top:#999 1px solid; padding-top:10px; margin-top:20px"></div>
        <p align="center">
            <strong>Welcome To Admin Of </strong>
            <a title="{SITE_NAME}" href="{NV_BASE_SITEURL}" style="text-decoration: none;"><strong style="color:#FF6600;">{SITE_NAME}</strong></a>. All rights reserved.
        </p>
        <script type="text/javascript">
            document.getElementById('login').focus();
        </script>
    </body>
</html>
<!-- END: main -->