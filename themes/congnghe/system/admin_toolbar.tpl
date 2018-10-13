<!-- BEGIN: main -->
<div id="toolbar">
    <ul class="info level{ADMIN_INFO.level} fl">
		<li>{GLANG.your_account}: <strong>{ADMIN_INFO.username}</strong></li>
    </ul>
    <div class="action fr">
		<a href="{NV_BASE_SITEURL}{NV_ADMINDIR}/index.php" title="{GLANG.admin_page}"><span class="icons1 icon-sitemanager">{GLANG.admin_page}</span></a>
		<!-- BEGIN: is_spadadmin -->
		<a href="{URL_DBLOCK}" title="{LANG_DBLOCK}"><span class="icons1 icon-drag">{LANG_DBLOCK}</span></a>
		<!-- END: is_spadadmin -->
		<!-- BEGIN: is_modadmin -->
        <a href="{URL_MODULE}" title="{GLANG.admin_module_sector}"><span class="icons1 icon-module">{GLANG.admin_module_sector}</span></a>
		<!-- END: is_modadmin -->
		<a href="{URL_AUTHOR}" title="{GLANG.your_account}"><span class="icons1 icon-users">{GLANG.your_account}</span></a>
		<a href="javascript:void(0);" onclick="nv_admin_logout();" title="{GLANG.logout}"><span class="icons1 icon-logout">{GLANG.logout}</span></a>
    </div>
</div>
<!-- END: main -->
