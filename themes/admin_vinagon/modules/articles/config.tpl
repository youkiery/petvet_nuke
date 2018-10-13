<!-- BEGIN: main -->
<form action="" method="post">
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody class="second">
		<tr>
			<td width="240"><strong>{LANG.setting_home_view}</strong></td>
			<td><select name="home_view">
				<!-- BEGIN: home_view_loop -->
				<option value="{type_view}"{view_selected}>{name_view}</option>
				<!-- END: home_view_loop -->
			</select></td>
		</tr>
	</tbody>
    <tbody>
		<tr>
			<td><strong>{LANG.setting_home_view}</strong></td>
			<td><select name="home_view_type">
				<!-- BEGIN: home_view_type_loop -->
				<option value="{type_view}"{view_selected}>{name_view}</option>
				<!-- END: home_view_type_loop -->
			</select></td>
		</tr>
	</tbody>
    <tbody class="second">
		<tr>
			<td><strong>{LANG.order}</strong></td>
			<td><select name="home_view_order">
				<!-- BEGIN: home_view_order_loop -->
				<option value="{type_view}"{view_selected}>{name_view}</option>
				<!-- END: home_view_order_loop -->
			</select></td>
		</tr>
	</tbody>
    <tbody>
        <tr>
            <td><strong>{LANG.setting_homesite}</strong></td>
            <td><input type="text" value="{DATA.homewidth}" style="width: 40px;" name="homewidth" /> x <input type="text" value="{DATA.homeheight}" style="width: 40px;" name="homeheight" /></td>
        </tr>
    </tbody>
    
	<tbody class="second">
		<tr>
			<td><strong>{LANG.setting_per_page}</strong></td>
			<td><input type="text" value="{DATA.per_page}" style="width: 40px;" name="per_page" /></td>
		</tr>
	</tbody>
    
    <tbody>
        <tr>
            <td><strong>{LANG.setting_per_row}</strong></td>
            <td><input type="text" value="{DATA.per_row}" style="width: 40px;" name="per_row" /></td>
        </tr>
    </tbody>
    
    <tbody class="second">
        <tr>
            <td><strong>{LANG.setting_hometext}</strong></td>
            <td><input type="checkbox" value="1" name="active_hometext" {ck_active_hometext} /></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><strong>{LANG.active_comment}</strong></td>
            <td><input type="checkbox" value="1" name="active_comment" {ck_active_comment} /></td>
        </tr>
    </tbody>
    <tbody class="second">
        <tr>
            <td><strong>{LANG.comment_auto}</strong></td>
            <td><input type="checkbox" value="1" name="comment_auto" {ck_comment_auto} /></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center; padding:10px">
            <input type="submit" value="{LANG.saveconfig}"/> 
            <input type="hidden" value="1" name="save">
            </td>
        </tr>
    </tbody>
</table>    
</form>
<!-- END: main -->
