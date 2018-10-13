<!-- BEGIN: main -->

<div id="module_show_list">

	<table class="tab1">

	<thead>

		<tr align="center">

			<td style="width:50px;">{LANG.weight}</td>

			<td style="width:40px;">ID</td>

			<td>{LANG.name_color}</td>

			<td style="width:100px;"></td>

		</tr>

	</thead>

	<!-- BEGIN: loop -->

	<tbody{ROW.class}>

		<tr>

			<td align="center">

				<select id="id_weight_{ROW.cid}"style="width: 60px;">

					<!-- BEGIN: weight -->

					<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>

					<!-- END: weight -->

				</select>

			</td>

			<td align="center"><b>{ROW.cid}</b></td>

			<td>

				{ROW.title}</a>

			</td>

			

			<td align="center">

				<span class="edit_icon"><a href="{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;cid={ROW.cid}#edit">{GLANG.edit}</a></span>

				&nbsp;-&nbsp;<span class="delete_icon"><a href="{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;cid={ROW.cid}&amp;ac=del">{GLANG.delete}</a></span>

			</td>

		</tr>

	</tbody>

	<!-- END: loop -->

</table>

</div>

<br />

<a id="edit"></a>

<!-- BEGIN: error -->

<div class="quote" style="width:98%">

	<blockquote class="error"><span>{ERROR}</span></blockquote>

</div>

<div class="clear"></div>

<!-- END: error -->

<form action="" method="post">

	<input type="hidden" name ="{NV_NAME_VARIABLE}"value="{MODULE_NAME}" />

	<input type="hidden" name ="{NV_OP_VARIABLE}"value="{OP}" />

	<input type="hidden" name ="bid" value="{DATA.bid}" />

	<input name="savecat" type="hidden" value="1" />

	<table summary="" class="tab1">

		<caption>{TITLE}</caption>

		<col width="150"/>

		<tbody>

			<tr>

				<td align="right"><strong>{LANG.name_color}: </strong></td>

				<td><input style="width: 650px" name="title" type="text" value="{DATA.title}" maxlength="255" /></td>

			</tr>

		</tbody>
		<tbody>

			<tr>

				<td valign="top" align="right" width="100px"><br><strong>{LANG.description}</strong></td>

				<td>

					<textarea style="width: 650px" name="description" cols="100" rows="5">{DATA.description}</textarea>

				</td>

			</tr>

		</tbody>

	</table>

	<br />

	<center><input name="submit1" type="submit" value="{LANG.save}" /></center>

</form>

<!-- END: main -->