<!-- BEGIN: main -->
<div id="edit">
	<!-- BEGIN: error -->
    <div class="quote" style="width:98%">
    	<blockquote class="error"><span>{ERROR}</span></blockquote>
    </div>
    <div class="clear"></div>
	<!-- END: error -->
    <form action="" method="post">
    <input name="save" type="hidden" value="1" />
    <input name="parentid_old" type="hidden" value="{DATA.parentid}" />
    <table summary="" class="tab1" style="margin-bottom:2px">
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.albums_title}: </strong></td>
				<td><input style="width: 600px" name="title" type="text" value="{DATA.title}" maxlength="255" id="idtitle"/></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.alias}: </strong></td>
				<td>
					<input style="width: 550px" name="alias" type="text" value="{DATA.alias}" maxlength="255" id="idalias"/>
					<input type="button" value="GET" onclick="get_alias();" style="font-size:11px"/>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.imgs_albums}: </strong></td>
				<td>
					<input style="width:400px" type="text" name="img" id="img" value="{DATA.img}"/>
                	<input type="button" value="Browse server" name="fileimg"/>
				</td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td valign="top" align="right"><strong>{LANG.description} </strong></td>
				<td>
				<textarea style="width: 600px" name="description" cols="100" rows="5">{DATA.description}</textarea>
				</td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td align="right"><strong>{LANG.keywords}: </strong></td>
				<td><input style="width: 600px" name="keywords" type="text" value="{DATA.keywords}" maxlength="255" /></td>
			</tr>
		</tbody>
		<tbody class="second">
		<tr>
			<td align="right"><strong>{LANG.who_view}</strong></td>
			<td> {who_views} </td>
        </tr>
        </tbody>
        <tbody id="id_groups_view">
        <tr>
            <td align="right"><strong>{LANG.groups_view}</strong></td>
            <td>    
                <!-- BEGIN: groups_views -->
                <span><input name="groups_view[]" type="checkbox" value="{groups_views.value}" {groups_views.check} />{groups_views.title}</span>
                <!-- END: groups_views -->
			</td>
		</tr>
		</tbody>
        <tbody>
        	<tr><td colspan="2" align="center">
            	<input name="submit1" type="submit" value="{LANG.save}" />
            </td></tr>
        </tbody>
    </table>
</form>
</div>
<script type="text/javascript">
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
<!-- END: getalias -->
show_group();
$("input[name=fileimg]").click(function(){
	var area = "img";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "file";
	nv_open_browse_file("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
</script>
<!-- END: main -->