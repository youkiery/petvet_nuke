<!-- BEGIN: main -->
<form action="" method="post" id="idfpost">
<input type="hidden" value="1" name="save"/>
<input type="hidden" value="0" name="status" id="idstatus" />
<!-- BEGIN: error -->
<div style="background:#FFF0F8; border:1px solid #FFCCFF; margin-bottom:2px; padding:5px">
    <span style="color:#FF0000">{error}</span>
</div>
<!-- END: error -->
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr>
        	<td width="120">{LANG.title}</td>
            <td>
            	<input type="text" value="{DATA.title}" name="title" id="idtitle" style="width:400px" />
            </td>
        </tr>
    </tbody>
    <tbody class="second">
        <tr>
        	<td width="120">{LANG.alias}</td>
            <td>
            	<input type="text" value="{DATA.alias}" name="alias" id="idalias" style="width:400px" />
                <input type="button" value="Get" onclick="get_alias()" />
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>{LANG.homefileimg}</td>
            <td>
                <input style="width:400px" type="text" name="homeimg" id="homeimg" value="{DATA.homefileimg}"/>
                <input type="button" value="Browse server" name="selectimg"/>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr><td>{LANG.hometext}</td></tr>
    </tbody>
    <tbody class="second">
    	<tr><td>
        <textarea style="width:99%; height:80px" name="hometext">{DATA.hometext}</textarea>
        </td></tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr>
            <td colspan="2">
                <input type="checkbox" name="link_active" value="1" {check_link} />{LANG.link_active}
            </td>
        </tr>
    	<tr>
        	<td width="120">{LANG.link_redirect}</td>
            <td>
            	<input type="text" value="{DATA.link_redirect}" name="link_redirect" style="width:99%" />
            </td>
        </tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr><td>{LANG.bodytext}</td></tr>
    </tbody>
    <tbody class="second">
    	<tr><td>
        {bodytext}
        </td></tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr>
        	<td>
            	{LANG.author} : <input type="text" value="{DATA.author}" name="author" style="width:200px" />&nbsp;&nbsp;
                {LANG.source} : <input type="text" value="{DATA.source}" name="source" style="width:200px" />
            </td>
        </tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr><td><b>{LANG.keyword}</b> {LANG.keyword_note}</td></tr>
    </tbody>
    <tbody class="second">
    	<tr><td>
        <textarea style="width:99%; height:60px" name="keywords">{DATA.keywords}</textarea>
        </td></tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr><td>
         <input type="checkbox" name="inhome" value="1" {check_inhome} />{LANG.inhome}	
         <input type="checkbox" name="allow_comment" value="1" {check_allow_comment} />{LANG.active_comment}	
        </td></tr>
    </tbody>
</table>
<table class="tab1" style="margin:0; margin-bottom:2px">
    <tbody>
    	<tr>
        	<td align="center">
                <input id="idsavetemp" type="button" value="{LANG.savetemp}" />
                <input id="idsave" type="button" value="{LANG.save}" />
            </td>
        </tr>
    </tbody>
</table>
</form>
<script type="text/javascript">
$("input[name=selectimg]").click(function(){
	var area = "homeimg";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "image";
	nv_open_browse_file(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "420","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
$("#idsavetemp").click(function () {
	$('#idstatus').val(0);
	$('#idfpost').submit();
});
$("#idsave").click(function () {
	$('#idstatus').val(1);
	$('#idfpost').submit();
});
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
	get_alias();
});
<!-- END: getalias -->
</script>
<!-- END: main -->
