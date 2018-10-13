<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
	<blockquote class="error">
		<span>{ERR}</span>
	</blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="{ACTION}" method="post">
	<input name="save" type="hidden" value="1" />
	<table class="tab1" id="items">
		<tbody>
			<tr>
				<td>{LANG.config_slider03}:</td>
				<td>
				<input style="width:400px" name="title" id="idtitle" type="text" value="{ROW.title}" maxlength="255" />
<br/>{LANG.config_slider04}
				</td>
			</tr>
			<tr>
				<td>{LANG.group_slider10}:</td>
				<td>
				<input style="width:400px" name="description" id="iddescription" type="text" value="{ROW.description}" maxlength="255" />
				</td>
			</tr>
		</tbody>
	</table>
	<div style="text-align:center">
		<input name="submit1" type="submit" value="{LANG.group_slider09}" />
	</div>