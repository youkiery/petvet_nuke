<!-- BEGIN: main -->
<ul id="mainnavtop">
	<li class="home">
		<a title="{LANG.Home}" href="{THEME_SITE_HREF}">{LANG.Home}</a>
	</li>
	<li class="deal">
		<a href="http://shoptv.vn" target="_blank">Sàn giá rẻ</a>
	</li>
    <li>
		<a href="http://docbaomoi.vn" target="_blank">Tin tức</a>
	</li>
	<!-- BEGIN: top_menu -->
	<li {TOP_MENU.current}>
		<a title="{TOP_MENU.title}" href="{TOP_MENU.link}">{TOP_MENU.title} </a>
		<!-- BEGIN: sub -->
		<ul id="dichvu_show">
			<!-- BEGIN: item -->
			<li class="clear">
				<a title="{SUB.title}" href="{SUB.link}">&raquo; {SUB.title}</a>
			</li>
			<!-- END: item -->
		</ul>
		<!-- END: sub -->
	</li><!-- END: top_menu -->
	<p class="date-time-head">
		{THEME_DIGCLOCK_TEXT}
	</p>
</ul>
<!-- END: main -->