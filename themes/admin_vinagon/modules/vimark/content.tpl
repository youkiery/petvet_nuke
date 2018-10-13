<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}js/jquery/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}js/jquery/jquery.autocomplete.css"/>
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
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:0px">
    <tr>
        <td valign="top">
        <table summary="" class="tab1" style="margin-bottom:0px">
            <tbody class="second">
                <tr>
                    <td><strong>{LANG.cus_name} </strong></td>
                    <td>
                        <input style="width: 98%" name="cus" type="text" value="{DATA.cus}" maxlength="255" id="idcus"/>
                        <input type="hidden" value="{DATA.cusid}" name="cusid" style="font-size:11px" id="idcus_value"/>
                    </td>    
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td width="180"><strong>{LANG.title_service} </strong></td>
                    <td><input style="width: 98%" name="title" type="text" value="{DATA.title}" maxlength="255" id="idtitle"/></td>
                </tr>
            </tbody>
            <tbody class="second">
                <tr>
                    <td><strong>{LANG.alias} </strong></td>
                    <td>
                        <input style="width: 80%" name="alias" type="text" value="{DATA.alias}" maxlength="255" id="idalias"/>
                        <input type="button" value="GET" onclick="get_alias();" style="font-size:11px"/>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td><strong>{LANG.cat_parent} </strong></td>
                    <td>
                    <select name="catid">
                        <!-- BEGIN: catlist -->
                        <option value="{ROW.catid}" {ROW.select}>{ROW.xtitle}</option>
                        <!-- END: catlist -->
                    </select>
                    </td>
                </tr>
            </tbody>
            <tbody class="second">
                <tr>
                    <td><strong>{LANG.content_price} ({money_unit})</strong></td>
                    <td>
                        <input style="width:120px" name="price" type="text" value="{DATA.price}" maxlength="255"/>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td><strong>{LANG.content_discount} ({money_unit})</strong></td>
                    <td>
                        <input style="width:120px" name="discount" type="text" value="{DATA.discount}" maxlength="255"/>
                    </td>
                </tr>
            </tbody>
            <tbody class="second">
                <tr>
                    <td><strong>{LANG.content_numbuy} </strong></td>
                    <td>
                        <input style="width:80px" name="numbuy" type="text" value="{DATA.numbuy}" maxlength="255"/>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td><strong>{LANG.content_timebuy}</strong></td>
                    <td>
                        {LANG.content_begintime} 
                        <input style="width:20px" name="hbegintime" type="text" value="{DATA.hbegintime}" maxlength="255"/> H:
                        <input style="width:20px" name="mbegintime" type="text" value="{DATA.mbegintime}" maxlength="255"/> '
                        <input style="width:100px" name="dbegintime" type="text" value="{DATA.dbegintime}" maxlength="255"/>
                        &nbsp;&nbsp;{LANG.content_endtime} 
                        <input style="width:20px" name="hendtime" type="text" value="{DATA.hendtime}" maxlength="255"/> H:
                        <input style="width:20px" name="mendtime" type="text" value="{DATA.mendtime}" maxlength="255"/> '
                        <input style="width:100px" name="dendtime" type="text" value="{DATA.dendtime}" maxlength="255"/>
                    </td>
                </tr>
            </tbody>
            <tbody class="second">
                <tr>
                    <td><strong>{LANG.content_address_sale} </strong></td>
                    <td>
                        <input style="width:98%" name="address_sale" type="text" value="{DATA.address_sale}" maxlength="255"/>
                    </td>
                </tr>
            </tbody>
        </table>   
        </td>
        <td width="2"></td>
        <td width="250" valign="top">
        	<table summary="" class="tab1" style="margin-bottom:0px">    
            <tbody class="second">
                <tr><td>
                    <strong>{LANG.group_title} </strong>
                </td></tr>
            </tbody>
            <tbody class="second">
                <tr><td>
                    <div style="padding:5px; margin:0; background:#FFF; border:1px solid #CCC; height:85px; overflow:auto">
                    <!-- BEGIN: gloop -->
                    <div><input type="checkbox" value="{GROUP.id}" name="group[]" {GROUP.check}/>{GROUP.title}</div>
                    <!-- END: gloop -->
                    </div>
                </td></tr>
            </tbody>
            <tbody class="second">
                <tr><td>
                    <strong>{LANG.city_buy} </strong>
                </td></tr>
            </tbody>
            <tbody class="second">
                <tr><td>
                    <div style="padding:5px; margin:0; background:#FFF; border:1px solid #CCC; height:87px; overflow:auto">
                    <!-- BEGIN: cityloop -->
                    <div><input type="checkbox" value="{CITY.id}" name="city[]" {CITY.check}/>{CITY.title}</div>
                    <!-- END: cityloop -->
                    </div>
                </td></tr>
            </tbody>
            </table>
        </td>
    </tr>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">    
    	<tbody class="second">
            <tr>
                <td width="140"><strong>{LANG.img} </strong></td>
                <td>
                    <input style="width:400px" type="text" name="img" id="img" value="{DATA.img}"/>
                	<input type="button" value="Browse server" name="fileimg"/>
                    <input type="button" value="{LANG.otherimg}" name="otherimg" id="otherimg" onclick="nv_add_otherimage();"/>
                </td>
            </tr>
        </tbody>
        <tbody id="otherimage">
            <!-- BEGIN: otherimage --> 
            <tr>
                <td align="center"><strong>{DATAOTHERIMAGE.id}</strong></td>
                <td>   
                    <input class="txt" value="{DATAOTHERIMAGE.value}" name="otherimage[]" id="otherimage_{DATAOTHERIMAGE.id}" style="width:400px" maxlength="255">
                    <input value="Browse server" onclick="nv_open_browse_file( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&amp;popup=1&amp;area=otherimage_{DATAOTHERIMAGE.id}&amp;path={NV_UPLOADS_DIR}/{module_name}&amp;currentpath={DATAOTHERIMAGE.curent}&amp;type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; " type="button">    
                </td>
            </tr>
            <!-- END: otherimage -->
        </tbody>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">    
        <tbody class="second">
        	<tr><td>
            	<strong>{LANG.homtext} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td>
            	<textarea name="hometext" style="width:99%; height:80px">{DATA.hometext}</textarea>
            </td></tr>
        </tbody>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">    
        <tbody class="second">
        	<tr><td>
            	<strong>{LANG.highlights} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td>
            	{edits_highlights}
            </td></tr>
        </tbody>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">    
        <tbody class="second">
        	<tr><td>
            	<strong>{LANG.conditions} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td>
            	{edits_conditions}
            </td></tr>
        </tbody>
    </table>
    <table summary="" class="tab1" style="margin-bottom:2px">    
    	<tbody class="second">
        	<tr><td colspan="2">
            	<strong>{LANG.bodytext} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td colspan="2">
            	{edits_bodytext}
            </td></tr>
        </tbody>
        <tbody class="second">
        	<tr><td colspan="2">
            	<strong>{LANG.content_sale} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td colspan="2">
            	{edits_content_sale}
            </td></tr>
        </tbody>
        <tbody class="second">
			<tr>
				<td width="80"><strong>{LANG.keywords} </strong></td>
				<td>
                	<input style="width: 80%" name="keywords" type="text" value="{DATA.keywords}" maxlength="255"  id="keywords"/>
                    <input type="button" value="Get" onclick="create_keywords()"/>
                </td>
			</tr>
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
var file_items='{FILE_ITEMS}';
var nv_base_adminurl = '{NV_BASE_ADMINURL}';
var file_dir='{NV_UPLOADS_DIR}/{module_name}';
var currentpath= "{CURRENT}";
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
<!-- END: getalias -->
$("input[name=selectfile]").click(function(){
	var area = "filepath";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "file";
	nv_open_browse_file("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
$("input[name=fileimg]").click(function(){
	var area = "img";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "file";
	nv_open_browse_file("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
</script>
<script type="text/javascript">
$("#idcus").autocomplete( script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=getcus', {
	minChars:2,
	onFindValue:formatItem,
	formatItem:formatItem,
	scrollHeight: 220
});
function formatItem(row) {
	return "" + row[0] + "" + "<br /><span class='looko'>"+row[1]+"</span>";
}
function formatResult(row) {
	return row[0].replace(/(<.+?>)/gi, '');
}
$("#idcus").result(function(event, data, formatted) {
      $("#idcus_value").val(data[2]);
});
</script>
<!-- END: main -->
