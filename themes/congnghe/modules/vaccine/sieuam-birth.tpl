<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>
<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<div id="reman"></div>
<div id="vac_panel" style="display: none; position: fixed; margin:auto; z-index: 1001;">
  <form>
    <table class="tab1" style="width: 500px;">
      <thead>
        <tr>
          <td colspan="2" style="text-align: center">
            {lang.confirm_mess}
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {lang.recall}
          </td>
          <td style="width: 60%;">
            <input id="confirm_recall" type="date" value="{now}">
          </td>
        </tr>
        <tr>
          <td>
            {lang.doctor}
          </td>
          <td>
            <select id="doctor_select" style="width: 100%; height: 2em;">
              <!-- BEGIN: doctor -->
              <option value="{doctorid}">
                {doctorname}
              </option>
              <!-- END: doctor -->
            </select>      
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center">
            <input id="btn_save_birth" type="button" style="height: 2em; padding: 4px;" onclick="save_form()" value="{lang.save}">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<form class="vac_form" method="GET">
  <input type="hidden" name="nv" value="{nv}">
  <input type="hidden" name="op" value="{op}">
  <input type="text" name="key" value="{keyword}" class="vac_input">
  <select name="limit">
    <!-- BEGIN: limit -->
    <option value="{limitvalue}" {lcheck}>{limitname}</option>
    <!-- END: limit -->
  </select>
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<table class="vng_vacbox tab1">
  <thead>
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
        {lang.doctor}
      </th>  
      <th>
        {lang.usgexbirth}
      </th>  
      <th>
        {lang.usgbirth}
      </th>  
      <th>
        {lang.usgbirthday}
      </th>  
      <th>

      </th>
    </tr>
  </thead>
  <tbody>
    <!-- BEGIN: list -->  
    <tr style="background: {bgcolor}; text-transform: capitalize;" img="{image}">
      <td>
        {index}
      </td>    
      <td class="petname">
        {petname}
      </td>    
      <td class="customer">
        {customer}
      </td>
      <td class="nphone">
        {phone}
      </td>    
      <td class="nphone">
        {doctor}
      </td>    
      <td class="dusinh">
        {exbirth}
      </td>
      <td class="dusinh">
        {birth}
      </td>
      <td class="sieuam">
        {birthday}
      </td>    
      <td style="text-align: center;">
        <button style="float: left;" onclick="confirm_lower({index}, {id}, {petid})">
          &lt;
        </button>
        <button style="float: right;" onclick="confirm_upper({index}, {id}, {petid})">
          &gt;
        </button>
        <p id="vac_confirm_{index}" style="color: {color};">
          {confirm}
        </p>
        <!-- BEGIN: recall_link -->
        <button id="recall_{index}" onclick="recall({index}, {id}, {petid})">
          {lang.recall}
        </button>
        <!-- END: recall_link -->
      </td>    
    </tr>
    <!-- END: list -->
    <tr>
      <td colspan="9">
        <p style="float: right;">
          {nav}
        </p>
      </td>
    </tr>
  </tbody>
</table>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=";
  var g_index = -1;
  var g_vacid = -1;
  var g_petid = -1;
  function confirm_upper(index, vacid, petid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link + "sieuam&action=cvsieuam&act=up&value=" + trim(value.innerText) + "&vacid=" + vacid, []).then(response => {
      response = JSON.parse(response);
      change_color(value, response, index, vacid, petid);
    })
  }

  $("#reman").click(() => {
    $("#vac_panel").fadeOut();
    $("#reman").hide();
  })

  function confirm_lower(index, vacid, petid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link + "sieuam&action=cvsieuam&act=low&value=" + trim(value.innerText) + "&vacid=" + vacid, []).then(response => {
      response = JSON.parse(response);
      change_color(value, response, index, vacid, petid);
    })
  }

  function change_color(e, response, index, vacid, petid) {
    if (response["status"]) {
      e.innerText = response["data"]["value"];
      e.style.color = response["data"]["color"];
        
      if (response["data"]["color"] == "green" && response["data"]["recall"] == "0") {
        console.log(e);
        
        e.parentElement.innerHTML += '<button id="recall_' + index + '" onclick="recall('+index+', '+vacid+', '+petid+')">Tái chủng</button>';
      } else {
        $("#recall_" + index).remove();
      }
    }
  }

  function recall(index, vacid, petid) {
    $("#reman").fadeIn();
    $("#vac_panel").fadeIn();
    $("#btn_save_birth").attr("disabled", true);
    $.post(
			link + "sieuam&act=post",
      {action: "getbirthrecall", vacid: vacid},
      (data, status) => {
				data = JSON.parse(data);
				g_vacid = vacid
				g_petid = petid
				g_index = index
        console.log(data);
        
				if (data["status"]) {
          $("#confirm_recall").val(data["data"]["calltime"])
          $("#doctor_select").html(data["data"]["doctor"])
          if (data["data"]["recall"] == 0) {
            $("#btn_save_birth").attr("disabled", false);
          }
				}
			}
    )
  }

  function save_form() {
    $.post(
      link + "sieuam&act=post",
      {action: "save", petid: g_petid, recall: $("#confirm_recall").val(), doctor: $("#doctor_select").val(), vacid: g_vacid},
      (data, status) => {
				data = JSON.parse(data);
				if (data["status"]) {
					$("#vac_panel").fadeOut();
					$("#reman").hide();
					$("#recall_" + g_index).remove();
					g_vacid = -1;
					g_petid = -1;
					g_index = -1;
				} else {

				}
			}
    )
  }


</script>
<!-- END: main -->