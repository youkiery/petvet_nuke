<!-- BEGIN: list -->
<table class="tab1" style="margin-bottom:2px">
<tr>
    <td>
    	<input type="text" value="{q}" name="q" id="query"/>
        <input type="button" onclick="search_cus()" value="{LANG.search}" />
        <input type="button" onclick="window.location='{ADDCONTENT}'" value="{LANG.add}" /> 
    </td>
</tr>            
</table>
<table class="tab1" style="margin-bottom:2px">
	<thead>
        <tr>
            <td align="center" width="50">{LANG.no_number}</td>
            <td>{LANG.cus_name}</td>
            <td>{LANG.cus_address}</td>
            <td align="center" width="100">{LANG.cus_phone}</td>
            <td width="220"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.class}>
        <tr>
            <td align="center">{ROW.no}</td>
            <td><a href="{ROW.link}">{ROW.name}</a></td>
            <td>{ROW.address}</td>
            <td align="center">{ROW.phone}</td>
            <td align="center">
            	<span class="add_icon"><a href="{ROW.add}">{LANG.addcontent}</a></span>&nbsp;
            	<span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span>&nbsp;
                <span class="delete_icon"><a href="{ROW.del}">{LANG.del}</a></span> 
            </td>
        </tr>
    </tbody>	
    <!-- END: loop -->
    <tfoot>
    	<tr>
            <td colspan="6" align="right">{generate_page}</td>
		</tr>
	</tfoot>
</table>
<!-- END: list -->
<!-- BEGIN: form -->
	<!-- BEGIN: error -->
    <div class="quote" style="width:98%">
    	<blockquote class="error"><span>{ERROR}</span></blockquote>
    </div>
    <div class="clear"></div>
	<!-- END: error -->
    <form action="" method="post">
    <input name="save" type="hidden" value="1" />
    <table summary="" class="tab1" style="margin-bottom:2px">
		<tbody>
			<tr>
				<td align="right" width="100px"><strong>{LANG.cus_name}: </strong></td>
				<td><input style="width: 600px" name="name" type="text" value="{DATA.name}" maxlength="255" id="idtitle"/></td>
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
				<td align="right"><strong>{LANG.cus_address}: </strong></td>
				<td><input style="width: 600px" name="address" type="text" value="{DATA.address}" maxlength="255"/></td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.cus_phone}: </strong></td>
				<td>
                	<input style="width: 200px" name="phone" type="text" value="{DATA.phone}" maxlength="255"/>
                    {LANG.cus_hotline}:
                    <input style="width: 200px" name="hotline" type="text" value="{DATA.hotline}" maxlength="255"/>
                </td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td align="right"><strong>{LANG.cus_website}:</strong> http://</td>
				<td><input style="width: 400px" name="website" type="text" value="{DATA.website}" maxlength="255"/></td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.cus_img}: </strong></td>
				<td>
                	<input style="width: 400px" name="img" type="text" value="{DATA.img}" maxlength="255" id="fileimg"/>
                	<input type="button" value="Browse server" name="fileimg"/>	
                </td>
			</tr>
		</tbody>
        </table>
        <table summary="" class="tab1" style="margin-bottom:2px; margin-top:2px">
		<tbody class="second">
			<tr>
				<td colspan="2"><strong>{LANG.cus_intro_short}: </strong></td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td colspan="2"><textarea style="width: 98%" name="intro_short" rows="5">{DATA.intro_short}</textarea></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td colspan="2"><strong>{LANG.cus_intro_detail}: </strong></td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td colspan="2">
                {editor}
                </td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td colspan="2"><strong>{LANG.cus_map}: </strong></td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td align="right"><strong>File server</strong></td>
                <td>
                	<input style="width: 400px" name="map" type="text" value="{DATA.map}" id="filemap" maxlength="255"/>
                    <input type="button" value="Browse server" name="filemap"/>
                </td>
			</tr>
            <tr>
				<td align="right"><strong>Link</strong></td>
                <td><textarea name="linkmap" style="width:98%; height:40px">{DATA.linkmap}</textarea></td>
			</tr>
		</tbody>
        <tbody>
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
$("input[name=filemap]").click(function(){
	var area = "filemap";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "file";
	nv_open_browse_file("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
$("input[name=fileimg]").click(function(){
	var area = "fileimg";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "file";
	nv_open_browse_file("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
</script>
<!-- END: form -->
<!-- BEGIN: del -->
<p align="center"><strong>{title}</strong></p>
<p align="center">{LANG.del_confim}</p>
<form action="" method="post">
    <input name="del" type="hidden" value="1" />
    <p align="center">
    	<input type="submit" value="{LANG.ok}"/>
    	<input type="button" value="{LANG.no}" onclick="window.location='{urlback}'"/>
        <input type="button" value="{LANG.cus_viewpro}" onclick="window.location='{urlview}'"/>
    </p>    
</form>    
<!-- END: del -->