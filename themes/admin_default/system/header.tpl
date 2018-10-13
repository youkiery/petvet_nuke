<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Language" content="vi" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="refresh" content="{NV_ADMIN_CHECK_PASS_TIME}" />
        <meta name="copyright" content="{NV_SITE_COPYRIGHT}" />
        <meta name="generator" content="{NV_SITE_NAME}" />
        <title>{NV_SITE_TITLE}</title>
        <link rel="StyleSheet" href="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/css/admin.css" type="text/css" />
        <!-- BEGIN: css_module -->
        <link rel="stylesheet" href="{NV_CSS_MODULE_THEME}" type="text/css" />
        <!-- END: css_module -->
        <script type="text/javascript" src="{NV_BASE_SITEURL}js/language/{NV_LANG_INTERFACE}.js">
        </script>
        <script type="text/javascript">
            var nv_siteroot = '{NV_BASE_SITEURL}';
            var nv_sitelang = '{NV_LANG_INTERFACE}';
            var nv_name_variable = '{NV_NAME_VARIABLE}';
            var nv_fc_variable = '{NV_OP_VARIABLE}';
            var nv_lang_variable = '{NV_LANG_VARIABLE}';
            var nv_module_name = '{MODULE_NAME}';
            var nv_my_ofs = {NV_SITE_TIMEZONE_OFFSET};
            var nv_my_abbr = '{NV_CURRENTTIME}';
            var nv_cookie_prefix = '{NV_COOKIE_PREFIX}';
            var nv_area_admin = 1;
        </script>
        <!--[if IE 6]>
            <script src="{NV_BASE_SITEURL}js/fix-png-ie6.js"></script>
            <script type="text/javascript">
            /* EXAMPLE */
            DD_belatedPNG.fix('.logo, img');
            /* string argument can be any CSS selector */
            /* .png_bg example is unnecessary */
            /* change it to what suits you! */
            </script>
        <![endif]-->
        <script type="text/javascript" src="{NV_BASE_SITEURL}js/global.js">
        </script>
        <script type="text/javascript" src="{NV_BASE_SITEURL}js/jquery/jquery.min.js">
        </script>
        <script type="text/javascript" src="{NV_BASE_SITEURL}js/admin.js">
        </script>
        <!-- BEGIN: module_js -->
        <script type="text/javascript" src="{NV_JS_MODULE}">
        </script>
        <!-- END: module_js --><!-- BEGIN: nv_add_editor_js -->{NV_ADD_EDITOR_JS}<!-- END: nv_add_editor_js --><!-- BEGIN: nv_add_my_head -->{NV_ADD_MY_HEAD}<!-- END: nv_add_my_head -->
    </head>
    <body>
        <div id="outer">
            <div id="header">
                <div class="logo">
                    <a title="{NV_SITE_NAME}" href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php"><img alt="{NV_SITE_NAME}" title="{SITE_NAME}" src="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/images/logo_small.png" width="240" height="50" /></a>
                </div><!-- BEGIN: langdata -->
                <div class="lang">
                    <strong>{NV_LANGDATA}</strong>: 
                    <select id="lang" onchange="top.location.href=this.options[this.selectedIndex].value;return;">
                        <!-- BEGIN: option --><option value="{LANGOP}"{SELECTED}>{LANGVALUE} </option>
                        <!-- END: option -->
                    </select>
                </div>
                <!-- END: langdata -->
                <div class="logout">
                    <a class="button1" href="{NV_GO_CLIENTSECTOR_URL}"><span><span>{NV_GO_CLIENTSECTOR}</span></span></a>
                    <a class="button1" href="javascript:void(0);" onclick="nv_admin_logout();"><span><span>{NV_LOGOUT}</span></span></a>
                </div>
            </div>
            <!-- BEGIN: top_menu -->
            <div id="topmenu">
                <ul>
                    <!-- BEGIN: top_menu_loop -->
                    <li {TOP_MENU_CURRENT}>
                        <a href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php?{NV_NAME_VARIABLE}={TOP_MENU_HREF}"><span><strong>&bull;</strong>{TOP_MENU_NAME}</span></a>
                    </li>
                    <!-- END: top_menu_loop -->
                </ul>
                <div class="right">
                </div>
                <div class="clear">
                </div>
            </div>
            <!-- END: top_menu -->
            <div id="top_message">
                <div class="clock_container">
                    <div class="clock">
                        <label>
                            <span id="digclock">{NV_DIGCLOCK}</span>
                        </label>
                    </div>
                </div>
                <div class="info">
                    <!-- BEGIN: hello_admin -->
                    {HELLO_ADMIN1} <!-- END: hello_admin -->
                    <!-- BEGIN: hello_admin3 -->
                    {HELLO_ADMIN3} <!-- END: hello_admin3 -->
                    <!-- BEGIN: hello_admin2 -->
                    {HELLO_ADMIN2} <!-- END: hello_admin2 -->
                </div>
                <div class="clear">
                </div>
            </div>
