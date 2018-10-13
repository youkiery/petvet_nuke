<!-- BEGIN: main -->
<div id="module_show_list">
<strong><a href="{link_menu}">{LANG.menuslider}</a></strong>
	<!-- BEGIN: table -->
	<table class="tab1">
		<thead>
			<tr>
				<td>{LANG.slider3}</td>
				<td align="center">{LANG.slider2}</td>
				<td align="center">{LANG.slider14}</td>
				<td align="center">{LANG.slider16}</td>
				<td align="center">{LANG.slider11}</td>
				<td align="center">{LANG.slider15}</td>
			</tr>
		</thead>
		<!-- BEGIN: loop1 -->
		<tbody {CLASS}>
			<tr>
				<td align="center" width="3%">
				<select id="change_weight_{ROW.id}" onchange="nv_chang_weight('{ROW.id}','weight');">
					<!-- BEGIN: weight -->
					<option value="{stt}" {select}>{stt}</option>
					<!-- END: weight -->
				</select></td>
				<td align="center">{ROW.title}</td>
				<td align="center" width="15%"><img border="0" alt="" src="{ROW.images}" width="115"/></td>
				<td>{ROW.links}</td>
				<td width="265">{ROW.bodytext}</td>
				<td width="10%"><span class="edit_icon"><a href="{ROW.linkedit}">{LANG2.edit}</a></span> &nbsp;-&nbsp;<span class="delete_icon"><a href="javascript:void(0);" onclick="nv_module_del({ROW.id})">{LANG2.delete}</a></span></td>
			</tr>
		</tbody>
		<!-- END: loop1 -->
		<thead>
			<tr>
				<td colspan="7" align="center"><span class="add_icon"><a href="{LINK_ADD}">{LANG.slider1}</a></span></td>
			</tr>
		</thead>
	</table>
	<!-- END: table -->
</div>
<!-- END: main -->