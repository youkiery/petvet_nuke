<!-- BEGIN: main -->
<!-- BEGIN: list -->
<table class="tab1" style="margin-bottom:2px">
	<thead>
        <tr>
            <td align="center" width="50">{LANG.weight}</td>
            <td>{LANG.group_title}</td>
            <td>{LANG.alias}</td>
            <td width="200"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.class}>
        <tr>
            <td align="center">{ROW.sweight}</td>
            <td><a href="{ROW.link}"><strong>{ROW.title}</strong></a></td>
            <td>{ROW.alias}</td>
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
				<td align="right"><strong>{LANG.group_title}: </strong></td>
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
				<td valign="top" align="right"><strong>{LANG.note} </strong></td>
				<td>
				<textarea style="width: 600px" name="note" cols="100" rows="5">{DATA.note}</textarea>
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
<script type="text/javascript">
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
<!-- END: getalias -->
</script>
<!-- END: form -->
<!-- END: main -->

<!-- BEGIN: catdel -->
<!-- BEGIN: subcat -->
<table summary="" class="tab1" style="margin-bottom:2px">
    <tbody>
    	<tr>
        	<td align="center">{TITLE}</td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<input type="button" value="{LANG.viewsubcat}" onclick="window.location='{PURL}'" />
            </td>
        </tr>
    </tbody>
</table>    
<!-- END: subcat-->
<!-- BEGIN: nonecat -->
<table summary="" class="tab1" style="margin-bottom:2px">
    <tbody>
    	<tr>
        	<td align="center">{TITLE}</td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<form action="" method="post">
                <input type="hidden" name="del" value="1" />
            	<input type="submit" value="{LANG.del_ok}"/>
                <input type="button" value="{LANG.no}" onclick="window.location='{PURL}'" />
                </form>
            </td>
        </tr>
    </tbody>
</table>    
<!-- END: nonecat-->
<!-- BEGIN: havecat -->
<table summary="" class="tab1" style="margin-bottom:2px">
    <tbody>
    	<tr>
        	<td align="center">{TITLE}</td>
        </tr>
    </tbody>
</table>
<table summary="" class="tab1" style="margin-bottom:2px">
    <tbody class="second">
    	<tr>
        	<td align="center">
            	{TITLE1}
            </td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<form action="" method="post">
                <input type="hidden" name="delcatall" value="1" />
            	<input type="submit" value="{LANG.del_ok}"/>
                </form>
            </td>
        </tr>
    </tbody>
</table>  
<table summary="" class="tab1" style="margin-bottom:2px">
    <tbody class="second">
    	<tr>
        	<td align="center">
            	{TITLE2}
            </td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<form action="" method="post">
                <input type="hidden" name="delcatmove" value="1" />
            	<select name="catid">
					<!-- BEGIN: catlist -->
					<option value="{ROW.catid}" {ROW.select}>{ROW.xtitle}</option>
					<!-- END: catlist -->
				</select>
                <input type="submit" value="{LANG.del_ok}"/>
                </form>
            </td>
        </tr>
    </tbody>
</table>  
<table summary="" class="tab1" style="margin-bottom:2px">
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<input type="button" value="{LANG.no}" onclick="window.location='{PURL}'" />
            </td>
        </tr>
    </tbody>
</table>      
<!-- END: havecat-->
<!-- END: catdel -->