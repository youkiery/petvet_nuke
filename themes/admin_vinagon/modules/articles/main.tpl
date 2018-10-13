<!-- BEGIN: main -->
<script type="text/javascript">
var lang_confirm = '{LANG.lang_confirm}';
</script>
<table class="tab1">
    <thead>
        <tr>
            <td width="30" align="center"><input type="checkbox" id="0" /></td>
            <td>{LANG.title}</td>
            <td width="80">{LANG.status}</td>
            <td width="100" align="center">{LANG.action}</td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {class}>
        <tr>
            <td align="center"><input type="checkbox" id="{ROW.id}" /></td>
            <td>{ROW.title}</td>
            <td align="center">{ROW.status}</td>
            <td>
                <span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span>
                &nbsp;-&nbsp;
                <span class="delete_icon"><a href="javascript:void(0);" onclick="nv_module_del({ROW.id})">{LANG.delete}</a></span>
            </td>
        </tr>
    </tbody>
    <!-- END: loop -->
    <tfoot>
    	<tr>
        	<td colspan="4">
            <span class="add_icon"><a href="{LINK_ADD}">{LANG.add_new}</a></span>
            {PAGES}
            </td>
         </tr>
    </tfoot>
</table>
<!-- END: main -->
