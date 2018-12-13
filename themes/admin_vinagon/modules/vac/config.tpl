<!-- BEGIN: main -->
<form class="vac_form" onsubmit="return filter()">
  <select id="f_sort" class="vac_select">
    <!-- BEGIN: fs_time -->
    <option value="{sort_value}" {fs_select}>
      {sort_name}
    </option>
    <!-- END: fs_time -->
  </select>
  <select id="f_moment" class="vac_select">
    <!-- BEGIN: fo_time -->
    <option value="{time_amount}" {fo_select}>
      {time_name}
    </option>
    <!-- END: fo_time -->
  </select>
  <input type="submit" class="vac_button" value="{lang.save}">
</form>
<script>
  var link = "/adminpet/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=config&act=post";
  function filter() {
		$.post(
			link,
			{action: "save", sort: $("#f_sort").val(), time: $("#f_moment").val()},
			(data, status) => {
			}
		)
    return false;
  }

</script>
<!-- END: main -->
