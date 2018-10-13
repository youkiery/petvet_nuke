<!-- BEGIN: main -->
<form action="" method="post">
<input type="hidden" name="savesetting" value="1" />
<table summary="" class="tab1">
  <tbody>
    <tr>
        <td align="right" width="280px" ><strong>{LANG.config_view_title}</strong></td>
        <td>
        	<select name="view_type">
                <!-- BEGIN: home_view_loop -->
                <option value="{ROW.value}" {ROW.select}>{ROW.title}</option>
                <!-- END: home_view_loop -->
            </select>
        </td>
    </tr>
  </tbody>
  <tbody calss="second">
    <tr>
        <td align="right"><strong>{LANG.config_view_num}</strong></td>
        <td><input style="width: 50px" name="view_num" type="text" value="{DATA.view_num}"/></td>
    </tr>
  </tbody>
  <tbody>
    <tr>
        <td align="right"><strong>{LANG.config_view_numper}</strong></td>
        <td><input style="width: 50px" name="view_numper" type="text" value="{DATA.view_numper}"/></td>
    </tr>
  </tbody>
  <tbody calss="second">
    <tr>
        <td align="right"><strong>{LANG.config_view_money}</strong></td>
        <td><input style="width: 50px" name="view_money" type="text" value="{DATA.view_money}"/></td>
    </tr>
  </tbody>
  <tbody>
    <tr>
        <td align="center" colspan="2">
        	<input type="submit" value="{LANG.save}" /> 
        </td>
    </tr>
  </tbody>
</table>
</form>
<script type="text/javascript">show_group();</script>
<!-- END: main -->