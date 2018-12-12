<!-- BEGIN: main -->
<div class="msgshow"></div>
<form class="vac_form" onsubmit="return filter()">
  <span>
      {lang.d_sort}
  </span>
  <select id="f_sort" class="vac_select">
    <!-- BEGIN: fs_time -->
    <option value="{sort_value}" {fs_select}>
      {sort_name}
    </option>
    <!-- END: fs_time -->
  </select>
  <br>
  <span>
      {lang.d_time}
  </span>
  <select id="f_moment" class="vac_select">
    <!-- BEGIN: fo_time -->
    <option value="{time_amount}" {fo_select}>
      {time_name}
    </option>
    <!-- END: fo_time -->
  </select>
  <br>
  <span>
      {lang.d_expert}
  </span>
  <select id="f_expert" class="vac_select">
    <!-- BEGIN: et_time -->
    <option value="{time_amount}" {et_select}>
      {time_name}
    </option>
    <!-- END: et_time -->
  </select>
  <br>
  <input type="submit" class="vac_button" value="{lang.save}">
</form>
<script>
  var link = "/adminpet/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=config&act=post";
  function filter() {
		$.post(
			link,
			{action: "save", sort: $("#f_sort").val(), time: $("#f_moment").val(), expert: $("#f_expert").val()},
			(data, status) => {
			    data = JSON.parse(data);
			    if (data["status"]) {
            alert_msg("{lang.saved}")
			    }
			}
		)
    return false;
  }

</script>
<!-- END: main -->
