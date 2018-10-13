<!-- BEGIN: main -->
<table summary="" class="tab1" style="margin:1px 0px">
    <tbody>
    <tr>
        <td>
            <input type="text" value="{q}" maxlength="64" name="q" id="idq" style="width: 200px">
        	<input type="button" value="{LANG.search}" onClick="search_rows()">
         </td>
    </tr>
    </tbody>
</table>
<table summary="" class="tab1" style="margin-bottom:5px">
    <thead>
        <tr>
            <td width="50" align="center">{LANG.no_st}</td>
            <td><a href="{base_url_name}">{LANG.albums_title}</a></td>
            <td align="center" width="100">{LANG.numitems}</td>
            <td align="center" width="80">{LANG.inhome}</td>
        	<td width="200"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.bg}>
    	<tr>
            <td align="center" width="20">
              {ROW.no}
            </td>
            <td style="line-height:18px">
            	<!-- BEGIN: img --><a href="{ROW.link}"><img src="{ROW.imgsrc}" width="60" height="40" style="float:left; margin-right:10px" /></a><!-- END: img -->
                <div><a href="{ROW.link}"><b>{ROW.title}</b></a></div>
                <div style="font-size:11px; color:#900">
                	{LANG.createby}: <strong>{ROW.full_name}</strong> | 
                	{LANG.addtime} : <strong>{ROW.time}</strong> | view : <strong>{ROW.view}</strong>
                </div>
            </td>
            <td align="center">{ROW.numitems}</td>
            <td align="center">{ROW.sinhome}</td>
        	<td align="center">
            	<span class="add_icon"><a href="{ROW.add}">{LANG.add_img}</a></span> - 
                <span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span> - 
                <span class="delete_icon"><a href="{ROW.del}" class="adel">{LANG.del}</a></span> 
            </td>
        </tr>
    </tbody>
    <!-- END: loop -->
    <tfoot>
    	<tr align="left">
	   		<td colspan="3">
                <span class="add_icon"><a href="{ADDCONTENT}">{LANG.add_albums}</a></span>
			</td>
            <td colspan="5" align="right"><!-- BEGIN: page -->{generate_page}<!-- END: page --></td>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
clickcheckall();
delete_one('adel','{LANG.del_confim}','{URLBACK}');
</script>
<!-- END: main -->