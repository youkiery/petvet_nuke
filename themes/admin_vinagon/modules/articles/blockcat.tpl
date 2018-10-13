<!-- BEGIN: main -->
<div id="module_show_list">
	{BLOCK_CAT_LIST}
</div>
<a id="edit"></a>
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
<blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php" method="post">
<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
<input type="hidden" name ="bid" value="{bid}" />
<input name="savecat" type="hidden" value="1" />
<table summary="" class="tab1">
	<tbody>
		<tr>
			<td align="right" width="120"><strong>{LANG.name}: </strong></td>
			<td><input style="width: 650px" name="title" id="idtitle" type="text" value="{title}" maxlength="255" /></td>
		</tr>
		<tr>
			<td valign="top" align="right"  width="100"><strong>{LANG.alias}: </strong></td>
			<td>
				<input style="width: 600px" name="alias" id="idalias" type="text" value="{alias}" maxlength="255" />
				<input type="button" value="Get" onclick="get_alias('blockcat', {bid});");
			</td>
		</tr>
	</tbody>
	<tbody class="second">
		<tr>
			<td align="right"><strong>{LANG.keyword}: </strong></td>
			<td><input style="width: 650px" name="keywords" type="text" value="{keywords}" maxlength="255" /></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td valign="top" align="right"  width="100"><br /><strong>{LANG.description}</strong></td>
			<td>
			<textarea style="width: 650px" name="description" cols="100" rows="5">{description}</textarea>
			</td>
		</tr>
	</tbody>
    <tbody class="second">
		<tr>
			<td colspan="2">
			<center><input name="submit1" type="submit" value="{LANG.save}" /></center>
			</td>
		</tr>
	</tbody>
</table>
</form>
<!-- BEGIN: getalias -->
<script type="text/javascript">
$("#idtitle").change(function () {
    get_alias( "blockcat", {bid} );
});
</script>
<!-- END: getalias -->
<!-- END: main -->