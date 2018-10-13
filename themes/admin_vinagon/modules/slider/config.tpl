<!-- BEGIN: main -->
<div id="module_show_list_group">
	<table class="tab1">
		<thead>
			<tr>
				<td>{LANG.group_slider01}</td>
				<td>{LANG.config_slider03}</td>
				<td>{LANG.group_slider10}</td>
				<td align="center">{LANG.group_slider03}</td>
			</tr>
		</thead>
		<!-- BEGIN: row -->
		<tbody{CLASS}>
			<tr>
				<td width="3%" style="text-align: center;">{ROW.weight}</td>
				<td width="30%"><strong>{ROW.title}</strong></td>
				<td>{ROW.description}</td>
				<td width="10%" align="center"><span class="edit_icon"><a href="{LINK_EDIT}">{LANG2.edit}</a></span> &nbsp;-&nbsp;<span class="delete_icon"><a href="javascript:void(0);" onclick="nv_module_del_config({ROW.id})">{LANG2.delete}</a></span></td>
			</tr>
			</tbody> <!-- END: row -->
			<thead>
				<tr>
					<td colspan="4" align="center"><span class="add_icon"><a href="{LINK_ADD}">{LANG.config_slider02}</a></span></td>
				</tr>
			</thead>
	</table>
</div>
<!-- END: main -->