<!-- BEGIN: main -->
<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<a href="/index.php?nv=vac">
	{lang.disease_title}
</a>
<form onsubmit="return search()">
  <input type="text" id="customer_key">
  <input type="submit" value="{lang.search}">
</form>
<form onsubmit="return filter()">
  <select id="f_sort">
    <option value="1">
      Thời gian tiêm phòng giảm dần
    </option>
    <option value="2">
      Thời gian tiêm phòng tăng dần
    </option>
    <option value="3">
      Thời gian tái chủng giảm dần
    </option>
    <option value="4">
      Thời gian tái chủng tăng dần
    </option>
  </select>
  <input type="date" id="f_fromtime" value="{fromtime}">
  <select id="f_moment">
    <!-- BEGIN: fo_time -->
    <option value="{time_amount}">
      {time_name}
    </option>
    <!-- END: fo_time -->
  </select>
  <input type="submit" value="{lang.filter}">
</form>
<div id="disease_display">
  <!-- BEGIN: disease -->
  <table class="vng_vacbox tab1">
    <thead>
      <tr>
        <th colspan="7" class="vng_vacbox_title" style="text-align: center">
          {title}
        </th>
      </tr>
      <tr>
        <th>
          {lang.index}
        </th>  
        <th>
          {lang.petname}
        </th>  
        <th>
          {lang.customer}
        </th>  
        <th>
          {lang.phone}
        </th>  
        <th>
          {lang.cometime}
        </th>  
        <th>
          {lang.calltime}
        </th>  
      	<th>
        	{lang.confirm}
      	</th>    
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: vac_body -->  
      <tr>
        <td>
          {index}
        </td>  
        <td>
          {petname}
        </td>  
        <td>
          {customer}
        </td>  
        <td>
          {phone}
        </td>  
        <td>
          {cometime}
        </td>  
        <td>
          {calltime}
        </td>  
				<td>
					<button onclick="confirm_lower({index}, {vacid}, {diseaseid})">
						&lt;
					</button>
          <div id="vac_confirm_{index}">
            {confirm}
          </div>
					<button onclick="confirm_upper({index}, {vacid}, {diseaseid})">
						&gt;
					</button>
				</td>
      </tr>
      <!-- END: vac_body -->
    </tbody>
  </table>
	<br>
	<!-- END: disease -->
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=";

  function confirm_upper(index, vacid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link +"confirm&act=up&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      console.log(response);
      response = JSON.parse(response);
      value.innerText = response["data"];
    })
  }

  function confirm_lower(index, vacid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link +"confirm&act=low&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      console.log(response);
      response = JSON.parse(response);
      value.innerText = response["data"];
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