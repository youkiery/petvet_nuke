<!-- BEGIN: tree -->
	<li class="{MENUTREE.class1}" ><a href="{MENUTREE.link}" {cla}>{MENUTREE.title}</a>	
		<!-- BEGIN: tree_content -->
			<ul>
			{TREE_CONTENT}
			</ul>
		<!-- END: tree_content -->                
	</li>
<!-- END: tree -->
<!-- BEGIN: main -->
	<!-- BEGIN: loopcat1 -->
<li id="menu-item-372" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-0 menu-item-simple-parent {CAT1.current} "><a  href="{CAT1.link}">{CAT1.title}</a>

<!-- BEGIN: cat2 -->
<ul class="sub-menu">
<!-- BEGIN: loopcat2 -->
	<li id="menu-item-2940" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-1"><a href="{CAT2.link}">{CAT2.title}</a>
    <!-- BEGIN: cat3 -->
	<ul class="sub-menu">
		{HTML_CONTENT}
		
	</ul>
    <!-- END: cat3 -->
</li>
<!-- END: loopcat2 -->	

</ul>
<!-- END: cat2 -->
</li>	<!-- END: loopcat1 -->
<!-- END: main -->