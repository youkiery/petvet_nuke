<!-- BEGIN: main -->
<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<a href="/index.php?nv=vac">
	{lang.disease_title}
</a>
<form class="vac_form" onsubmit="return search()">
  <input type="text" id="customer_key" class="vac_input">
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<form class="vac_form" onsubmit="return filter()">
  <select id="f_sort" class="vac_select">
    <!-- BEGIN: fs_time -->
    <option value="{sort_value}" {fs_select}>
      {sort_name}
    </option>
    <!-- END: fs_time -->
  </select>
  <input type="date" id="f_fromtime" class="vac_input" value="{fromtime}">
  <select id="f_moment" class="vac_select">
    <!-- BEGIN: fo_time -->
    <option value="{time_amount}" {fo_select}>
      {time_name}
    </option>
    <!-- END: fo_time -->
  </select>
  <input type="submit" class="vac_button" value="{lang.filter}">
</form>
<div id="disease_display">
  {content}
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=";

  function confirm_upper(index, vacid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link +"confirm&act=up&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      console.log(response);
      response = JSON.parse(response);
      if(response["status"]) value.innerText = response["data"];
    })
  }

  function confirm_lower(index, vacid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link +"confirm&act=low&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      console.log(response);
      response = JSON.parse(response);
      if(response["status"]) value.innerText = response["data"];
    })
  }

  function search() {
    var key = document.getElementById("customer_key").value;
    var fromtime = document.getElementById("f_fromtime").value;
    var time_amount = document.getElementById("f_moment").value;
    var sort = document.getElementById("f_sort").value;
    fetch(link +"search&key=" + key + "&fromtime=" + fromtime + "&time_amount=" + time_amount + "&sort=" + sort, []).then(response => {
      document.getElementById("disease_display").innerHTML = response;
    })
    return false;    
  }

  function filter() {
    var fromtime = document.getElementById("f_fromtime").value;
    var time_amount = document.getElementById("f_moment").value;
    var sort = document.getElementById("f_sort").value;
    var data = ["action=filter", "fromtime=" + fromtime, "time_amount=" + time_amount, "sort=" + sort];
    fetch(link + "main&act=post", data).then(response => {
      data = JSON.parse(response);
      document.getElementById("disease_display").innerHTML = data["data"];
    })
    return false;
  }

</script>
<!-- END: main -->