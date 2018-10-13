<!-- BEGIN: main -->
<table summary="" class="tab1" style="margin:1px 0px">
    <tbody>
    <tr>
        <td>
            <select name="catid" id="catid">
                <option value="0">{LANG.search_all}</option>
                <!-- BEGIN: cloop -->
                <option value="{CAT.catid}" {CAT.select}>{CAT.xtitle}</option>
                <!-- END: cloop -->
            </select>
            <input type="text" value="{q}" maxlength="64" name="q" id="idq" style="width: 200px">
        	<input type="button" value="{LANG.search}" onClick="search_rows()">
         </td>
    </tr>
    </tbody>
</table>
<table summary="" class="tab1" style="margin-bottom:5px">
    <thead>
        <tr>
            <td align="center" width="20">
               <input name="check_all" id="checkall" type="checkbox"/>
            </td>
            <td><a href="{base_url_name}">{LANG.title_service}</a></td>
            <td width="60">{LANG.main_price}</td>
            <td width="60">{LANG.main_discount}</td>
      <td align="center" width="60">{LANG.status}</td>
        	<td width="90" align="center">{LANG.action}</td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.bg}>
    	<tr>
        	<td align="center" width="20">
              <input type="checkbox" value="{ROW.id}" class="idlist"/>
            </td>
            <td>
            	<!-- BEGIN: img --><img src="{ROW.img}" width="50" height="40" style="float:left; margin-right:5px"/><!-- END: img -->
  				<div style="line-height:18px">
                	<a href="{ROW.link}" target="_blank"><b>{ROW.title}</b></a> <br />
          			<span style="font-size:11px">
                    	{LANG.view}: <strong>{ROW.view}</strong> | 
                        {LANG.main_comment}: <strong>{ROW.comment}</strong> | 
                        {LANG.buy}: <strong>{ROW.bought}</strong> | 
                        {LANG.main_like}: <strong>{ROW.like}</strong> | 
                        {LANG.cat_title}: <a href="{ROW.cat_link}">{ROW.cat_title}</a>
          			</span>
                </div>
                <a href="{ROW.cus}" style="font-size:11px">{ROW.name}</a>
            </td>
            <td>{ROW.price}</td>
            <td align="center">{ROW.discount_p}</td>
        <td align="center">{ROW.status}</td>
        	<td align="center">
            	<span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span> - 
                <span class="delete_icon"><a href="{ROW.del}" class="adel">{LANG.del}</a></span> 
            </td>
        </tr>
    </tbody>
    <!-- END: loop -->
    <tfoot>
    	<tr align="left">
	   		<td colspan="3">
                <span class="delete_icon"><a href="#" class="delall">{LANG.del_select}</a></span>&nbsp;
                <span class="add_icon"><a href="{ADDCONTENT}">{LANG.add}</a></span>
			</td>
            <td colspan="5" align="right"><!-- BEGIN: page -->{generate_page}<!-- END: page --></td>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
clickcheckall();
delete_one('adel','{LANG.del_confim}','{URLBACK}');
delete_all('idlist','delall','{LANG.del_confim}','{LANG.no_select_items}','{DELALL}','{URLBACK}');
</script>
