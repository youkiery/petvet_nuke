<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
	<blockquote class="error">
		<span>{ERR}</span>
	</blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="{ROW.action}" method="post">
	<input name="save" type="hidden" value="1" />
	<table summary="" class="tab1" style="margin-top:8px;margin-bottom:8px;">
		<col valign="top" width="150px" />
		<tr>
			<td>{LANG.slider2}</td>
			<td>
			<input style="width:400px" name="title" id="idtitle" type="text" value="{ROW.title}" maxlength="255" />
			</td>
		</tr>
<tr>
<td>{LANG.group_slider02}:</td>
<td>
	<select name="idgroup">
<!-- BEGIN: group -->
	<option value="{ROWS.id}" {select}>{ROWS.title}</option>";
<!-- END: group -->
	</select>
</td>
</tr>

		<tr>
			<td>{LANG.alias}</td>
			<td>
			<input style="width:380px" name="alias" id="idalias" type="text" value="{ROW.alias}" maxlength="255" />
			<img src="{NV_BASE_SITEURL}images/refresh.png" width="16" style="cursor: pointer; vertical-align: middle;" onclick="get_alias({ROW.id});" alt="" height="16" /></td>
		</tr>
		<tr>
			<td>{LANG.slider14}</td>
			<td><img src="{ROW.images}" alt="" width="100" style="cursor: pointer; vertical-align: middle; margin-right: 10px;" />
			<input style="width:400px" name="images" id="idimages" type="text" value="{ROW.images}" maxlength="255" />
			<input type="button" name="browseimages" value="Browse server">
			</td>
		</tr>
		<tr>
			<td>{LANG.slider16}</td>
			<td>
			<input style="width:400px" name="links" id="idlinks" type="text" value="{ROW.links}" maxlength="255" />
			</td>
		</tr>
		<tr>
			<td colspan="2">{LANG.slider11}</td>
		</tr>
		<tr>
			<td colspan="2"> {edit_bodytext} </td>
		</tr>
	</table>
	<br />
	<div style="text-align:center">
		<input name="submit1" type="submit" value="{LANG.save}" />
	</div>
</form>
<script type="text/javascript">
	if(empty($alias)) {
		$contents. = '$("#idtitle").change(function () {
		get_alias(' . $id . ');
	});';
	}
</script>
<script type="text/javascript">
	//<![CDATA[
	$("input[name=browseimages]").click(function() {
		var area = "idimages";
		var path = "uploads/{MODULE_NAME}";
		var currentpath = "uploads/{MODULE_NAME}";
		var type = "image";
		nv_open_browse_file(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", "850", "420", "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});

</script>
<!-- END: main -->