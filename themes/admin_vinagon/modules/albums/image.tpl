<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:98%">
    <blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="" method="post" id="idcontent">
<input name="save" type="hidden" value="1" />
<input name="status" type="hidden" value="0" id="idstatus"/>
<input name="parentid_old" type="hidden" value="{DATA.parentid}" />
    <table summary="" class="tab1" style="margin-bottom:2px">
		<tbody>
			<tr>
				<td width="180"><strong>{LANG.title_img} </strong></td>
				<td><input style="width: 600px" name="title" type="text" value="{DATA.title}" maxlength="255" id="idtitle"/></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td><strong>{LANG.alias} </strong></td>
				<td>
					<input style="width: 550px" name="alias" type="text" value="{DATA.alias}" maxlength="255" id="idalias"/>
					<input type="button" value="GET" onclick="get_alias();" style="font-size:11px"/>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td><strong>{LANG.imgof} </strong></td>
				<td>
				<strong>{albums_title}</strong>
                <input type="hidden" value="{albums_id}" name="aid"/>
				</td>
			</tr>
		</tbody>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">
    	<tbody class="second">
			<tr>
				<td colspan="2"><strong>{LANG.pathfile}</strong></td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td align="right"><strong>{LANG.serverpathfile} </strong></td>
				<td>
				<input style="width:400px" type="text" name="img" id="img" value="{DATA.img}"/>
                <input type="button" value="Browse server" name="fileimg"/>
				</td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.otherpathfile} </strong></td>
				<td>
				<input style="width:500px" type="text" name="otherpath" value="{DATA.otherpath}"/>
				</td>
			</tr>
		</tbody>
    </table>    
    <table summary="" class="tab1" style="margin-bottom:2px">    
        <tbody class="second">
        	<tr><td>
            	<strong>{LANG.description} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td>
            	<textarea style="width: 99%" name="description" rows="5">{DATA.description}</textarea>
            </td></tr>
        </tbody>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">    
        <tbody>
        	<tr><td align="center">
            	<input name="submit1" type="button" value="{LANG.save_no}" onclick="content_submit(0)" />
            	<input name="submit1" type="button" value="{LANG.save_yes}" onclick="content_submit(1)"/>
            </td></tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
<!-- END: getalias -->
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
