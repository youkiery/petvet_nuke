<!-- BEGIN: main -->
<form class="vac_form" method="GET">
	<input type="hidden" name="nv" value="{nv}">
	<p>
		Từ khóa:
		<input type="text" name="key" value="{keyword}">
	</p>

  <select id="f_sort" name="sort" class="vac_select">
    <!-- BEGIN: fs_time -->
    <option value="{sort_value}" {fs_select}>
      {sort_name}
    </option>
    <!-- END: fs_time -->
  </select>
  <select id="f_moment" name="time" class="vac_select">
    <!-- BEGIN: fo_time -->
    <option value="{time_amount}" {fo_select}>
      {time_name}
    </option>
    <!-- END: fo_time -->
  </select>
  <input type="submit" class="vac_button" value="{lang.save}">
</form>
{table}
<script>
  var link = "/adminpet/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=main&act=post";
  function filter() {
		$.get(
			link,
			{sort: $("#f_sort").val(), time: $("#f_moment").val()},
			(data, status) => {
				// console.log(data);
				
			}
		)
    return false;
  }
</script>
<!-- END: main -->