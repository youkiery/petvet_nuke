<!-- BEGIN: main -->
	<!-- BEGIN: header --> 
	{FILE "header.tpl"}
	<!-- END: header -->
    <script type="text/javascript">
		// click hide menu
		function clickHide(type){
			if (type == 1){
				$('td.colum_left_lage').hide({ direction: "horizontal" }, 500);
				$('td.colum_left_small').show({ direction: "horizontal" }, 500);
				nv_setCookie( 'colum_left_lage', '0', 86400000);
			}
			else {
				if (type == 2){
					$('td.colum_left_small').hide(0);
					$('td.colum_left_lage').show({ direction: "horizontal" }, 500);
						nv_setCookie( 'colum_left_lage', '1', 86400000);
				}
			}
		}
		// show or hide menu 
		function show_menu(){
			var showmenu = ( nv_getCookie( 'colum_left_lage' ) ) ? ( nv_getCookie('colum_left_lage')) : '1';
			if (showmenu == '1') {
				$('td.colum_left_small').hide();
				$('td.colum_left_lage').show();
			}else {
				$('td.colum_left_small').show();
				$('td.colum_left_lage').hide();
			}
		}
		////
    </script>
	<div id="middle_outer">
    	<table cellpadding="0" cellspacing="0" width="100%" border="0" class="table_full">
        <tr>
        	<td valign="top" class="colum_left_small">
                <span class="lage" onclick="clickHide(2)">&nbsp;</span>
        	</td>
	    	<td valign="top" class="colum_left_lage">
            	<div style="padding-right:20px; padding-left:4px; width:200px">
                    <div class="divclose"><span class="small" onclick="clickHide(1)">&nbsp;</span></div>
                    <div id="middle_column_l">
                        <!-- BEGIN: vertical_menu -->
                        <div id="ver_menu">
                            <!-- BEGIN: vertical_menu_loop -->
                            <a {VERTICAL_MENU_CURRENT}  href="{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}={VERTICAL_MENU_HREF}">{VERTICAL_MENU_NAME}  </a>
                            <!-- BEGIN: vertical_menu_sub_loop -->
                            <a {VERTICAL_MENU_SUB_CURRENT}  
                            href="{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}={VERTICAL_MENU_SUB_HREF}&amp;{NV_OP_VARIABLE}={VERTICAL_MENU_SUB_HREF1}">
                            {VERTICAL_MENU_SUB_NAME}  </a>
                            <!-- END: vertical_menu_sub_loop -->
                            <!-- END: vertical_menu_loop -->
                        </div>
                        <!-- END: vertical_menu -->
                    </div>
                </div>
            	<script type="text/javascript">show_menu();</script>
        	</td>

            <td valign="top" bgcolor="#F2F2F2">
            	<div class="info_tab">
                    <!-- BEGIN: empty_page_title -->
                    <span class="cell_left">{PAGE_TITLE}</span>
                    <!-- END: empty_page_title -->
                    
                    <!-- BEGIN: select_option -->
                    <span class="cell_right">
                        <select name="select_options" onchange="top.location.href=this.options[this.selectedIndex].value;return;">
                            <option value="">{PLEASE_SELECT}</option>
                            <!-- BEGIN: select_option_loop -->
                            <option value="{SELECT_VALUE}">{SELECT_NAME}</option>
                            <!-- END: select_option_loop -->
                        </select>
                    </span>
                    <!-- END: select_option -->
                    <!-- BEGIN: site_mods -->
                    <span class="cell_right">
                        <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}">{NV_GO_CLIENTMOD}</a>
                    </span>
                    <!-- END: site_mods -->
                    <div style="clear:both"></div>
                </div>
	    		<div id="middle_column_r">
                    {THEME_ERROR_INFO}
                    {MODULE_CONTENT}
                    <div style="clear:both"></div>
	    		</div>
        	</td>
        </tr>
	    </table>
	</div>
	<!-- BEGIN: footer -->
	{FILE "footer.tpl"}
	<!-- END: footer -->
<!-- END: main -->