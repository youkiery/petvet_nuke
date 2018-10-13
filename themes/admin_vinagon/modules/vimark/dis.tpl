<!-- BEGIN: main -->
<!-- BEGIN: list -->
<table class="tab1" style="margin-bottom:2px">
	<thead>
        <tr>
            <td>{LANG.dis_title}</td>
            <td>{LANG.dis_city}</td>
            <td width="200"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.class}>
        <tr>
            <td><strong>{ROW.title}</strong></td>
            <td>{ROW.dis_city}</td>
            <td align="center">
            	<span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span>&nbsp;
                <span class="delete_icon"><a href="{ROW.del}" class="del_one">{LANG.del}</a></span> 
            </td>
        </tr>
    </tbody>	
    <!-- END: loop -->
</table>
<script type="text/javascript">
delete_one('del_one','{LANG.del_confim}','{url_back}');
</script>
<!-- END: list --> 
<!-- BEGIN: form -->
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
				<td align="right"><strong>{LANG.dis_title}: </strong></td>
				<td><input style="width: 600px" name="title" type="text" value="{DATA.title}" maxlength="255" id="idtitle"/></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.dis_city}: </strong></td>
				<td>
					<select name="idcity">
                    	<!-- BEGIN: cloop -->
                    	<option value="{CITY.id}" {CITY.select}>{CITY.title}</option>
                        <!-- END: cloop -->
                    </select>
				</td>
			</tr>
		</tbody>
        <tbody class="second">
        	<tr><td colspan="2" align="center">
            	<input name="submit1" type="submit" value="{LANG.save}" />
            </td></tr>
        </tbody>
    </table>
</form>
</div>
<!-- END: form -->
<!-- END: main -->