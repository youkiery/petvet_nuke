<!-- BEGIN: main -->
<form action="{NV_BASE_ADMINURL}index.php" method="GET">
    <input type="hidden" name ="{NV_NAME_VARIABLE}" value="{module_name}" />
    <input type="hidden" name ="{NV_OP_VARIABLE}" value="{op}" />
<table summary="" class="tab1" style="margin:1px 0px">
    <tbody>
    <tr>
        <td>
        	{LANG.search_cat} :
            <select name="catid">
                <option value="0">{LANG.search_cat_all}</option>
                <!-- BEGIN: cloop -->
                <option value="{CATE.catid}" {CATE.sl}>{CATE.xtitle}</option>
                <!-- END: cloop -->
            </select>
            <select name="stype">
            	<!-- BEGIN: sloop -->
           		<option value="{ROW.key}" {ROW.sl}>{ROW.val}</option>
                <!-- END: sloop -->
            </select>
         	{LANG.search_per_page}
         	<input type="text" name="per_page" value="{per_page}" style="width:50px" />
         </td>
    </tr>
    </tbody>
</table>
<table summary="" class="tab1" style="margin:1px 0px">   
    <tbody class="second">
    <tr>
        <td>
        	<input type="text" value="{q}" maxlength="64" name="q" style="width: 265px">
        	<input type="submit" value="{LANG.search}">
        	{LANG.search_note}
        </td>
    </tr>
    </tbody>
</table>
<input type="hidden" name ="checkss" value="{session_id}"/>
</form>

<form name="block_list">
<table summary="" class="tab1" style="margin-bottom:5px">
    <thead>
        <tr>
            <td align="center" width="20">
               <input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"/>
            </td>
            <td width="50" align="center"><a href="{base_url_id}">ID</a></td>
            <td><a href="{base_url_name}">{LANG.name}</a></td>
            <td width="180">{LANG.search_cat}</td>
            <td align="right" width="100"><a href="{base_url_price}">{LANG.content_product_product_price}</a></td>
            <td align="center" width="60">{LANG.status}</td>
            <td align="center" width="60"><a href="{base_url_number}">{LANG.content_product_number1}</a></td>
        	<td width="90"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.bg}>
    	<tr>
        	<td align="center" width="20">
              <input type="checkbox" onclick="nv_UncheckAll(this.form,'idcheck[]','check_all[]',this.checked);" value="{ROW.id}" name="idcheck[]"/>
            </td>
            <td align="center">
             	<!-- BEGIN: img -->
                <a href="{ROW.link}" target="_blank">
                <img src="{ROW.thumb}" width="40" height="30" style="padding:2px; border:1px solid #CCC; background:#FFF" />
                </a>
                <!-- END: img -->
            </td>
            <td>
            	<a href="{ROW.link}" target="_blank">{ROW.title}</a><br />
            	<span style="color:#F60;font-size:11px">{LANG.content_product_discounts} : {ROW.product_discounts} vnd</span> |  
                <span style="color:#999;font-size:11px">{LANG.order_update} : {ROW.publtime}</span> |
                <span style="color:#999;font-size:11px">{LANG.content_admin} : {ROW.admin_name}</span>
            </td>
            <td><a href="{ROW.link_cat}">{ROW.pro_cat}</a></td>
            <td align="right">{ROW.product_price} {ROW.money_unit}</td>
            <td align="center">{ROW.status}</td>
            <td align="center">{ROW.product_number}</td>
        	<td align="center">
            	{ROW.edit} - {ROW.del}
            </td>
        </tr>
    </tbody>
    <!-- END: loop -->
    <tfoot>
    	<tr align="left">
	   		<td colspan="3">
				<select name="action" id="action">
                	<!-- BEGIN: aloop -->
					<option value="{ROW.catid}">{ROW.title}</option>
                    <!-- END: aloop -->
                </select>
				<input type="button" onclick="nv_main_action(this.form,'{md5ck}','{LANG.msgnocheck}')" value="{LANG.action}">
			</td>
            <td colspan="5" align="right"><!-- BEGIN: page -->{generate_page}<!-- END: page --></td>
		</tr>
	</tfoot>
</table>
</form>
<!-- END: main -->