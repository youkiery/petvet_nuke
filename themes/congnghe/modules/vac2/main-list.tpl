<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<div id="reman"></div>
<ul>
  <li>
    <a href="{list}"> {lang.list} </a>
  </li>
  <li>
    <a href="{rlist}"> {lang.list2} </a>
  </li>
</ul>
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
            <input id="confirm_recall" type="date">
          </td>
        </tr>
        <tr>
          <td>
            {lang.doctor}
          </td>
          <td>
            <select id="confirm_doctor" style="width: 100%; height: 2em;">
            </select>      
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center">
            <input type="button" style="height: 2em; padding: 4px;" onclick="save_form()" value="{lang.save}">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<form class="vac_form">
  <input type="hidden" name="nv" value="vac2">
  <input type="hidden" name="op" value="main-list">
  <input type="hidden" name="page" value="{page}">
  <input type="text" name="keyword" value="{keyword}">
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<div id="disease_display">
<!-- BEGIN: disease -->
<table class="vng_vacbox tab1">
  	<thead>
    	<tr>
      	<th colspan="9" class="vng_vacbox_title" style="text-align: center">
        	{lang.main_title}
      	</th>
    	</tr>
    	<tr>
        <th style="width: 20px;">
          {lang.index}
        </th>  
        <th style="width: 100px;">
          {lang.petname}
        </th>  
        <th style="width: 130px;">
          {lang.customer}
        </th>  
        <th style="width: 80px;">
          {lang.phone}
        </th>  
        <th style="width: 50px;">
          {lang.disease}
        </th>  
        <th style="width: 50px;">
          {lang.cometime}
        </th>  
        <th style="width: 50px;">
          {lang.calltime}
        </th>  
      	<th style="width: 100px;">
        	{lang.confirm}
				</th>
				<th>
					{lang.note}
				</th>
    	</tr>
  	</thead>
  	<tbody>
    	<!-- BEGIN: body -->  
    	<tr style="background: {bgcolor}; text-transform: capitalize;">
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
        	{disease}
				</td>    
      	<td>
        	{cometime}
      	</td>    
      	<td>
        	{calltime}
				</td>    
				<td style="text-align: center;">
					<button style="float: left;" onclick="confirm_lower({index}, {vacid}, {petid}, {diseaseid})">
						&lt;
					</button>
          <span id="vac_confirm_{diseaseid}_{index}" style="color: {color};">
            {confirm}
          </span>
					<button style="float: right;" onclick="confirm_upper({index}, {vacid}, {petid}, {diseaseid})">
						&gt;
					</button>
					<!-- BEGIN: recall -->
						<button id="recall_{index}" onclick="recall({index}, {vacid}, {petid}, {diseaseid})">
							{lang.recall}
						</button>
					<!-- END: recall -->
				</td>
				<td>
					<img class="mini-icon" src="/uploads/vac/note_add.png" alt="thêm ghi chú" onclick="editNote({vacid}, {diseaseid})">
					<img class="mini-icon" src="/uploads/vac/note_info.png" alt="xem ghi chú" onclick="viewNote({vacid}, {diseaseid})">
				</td>
			</tr>
			<tr style="display: none; background: #fa0;" id="note_{diseaseid}_{vacid}">
				<td colspan="9" id="note_v{diseaseid}_{vacid}">
					{note}
				</td>
			</tr>
    	<!-- END: body -->
  	</tbody>
	</table>
<br>
<!-- END: disease -->
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=main-process&method=post";
  var g_index = -1;
  var g_vacid = -1;
  var g_disease = -1;
  var g_petid = -1;
  $("#reman").click(() => {
    $("#vac_panel").fadeOut();
    $("#reman").hide();
  })

  function confirm_lower(index, vacid, petid, diseaseid) {
    var e = document.getElementById("vac_confirm_" + diseaseid + "_" + index);
    $.post(
      link,
      {action: "confirm", act: "down", value: trim(e.innerText), id: vacid, diseaseid: diseaseid},
      (response, status) => {
        data = JSON.parse(response);
        change_color(e, data, index, vacid, petid, diseaseid);
      }
    )
  }

  function confirm_upper(index, vacid, petid, diseaseid) {
    var e = document.getElementById("vac_confirm_" + diseaseid + "_" + index);
    $.post(
      link,
      {action: "confirm", act: "up", value: trim(e.innerText), id: vacid, diseaseid: diseaseid},
      (response, status) => {
        data = JSON.parse(response);
        change_color(e, data, index, vacid, petid, diseaseid);
      }
    )
  }

  function change_color(e, response, index, vacid, petid, diseaseid) {
    if (response["status"]) {
      e.innerText = response["data"]["value"];
      e.style.color = response["data"]["color"];
      if (response["data"]["color"] == "green" && !response["data"]["recall"]) {
        e.parentElement.innerHTML += "<button id='recall_" + index + "' onclick='recall(" + index + ", " + vacid + ", " + petid + ", " + diseaseid + ")'>Tái chủng</button>";
      } else {
        $("#recall_" + index).remove();
      }
    }
  }

  function save_form() {
    $.post(
      link,
      {action: "save", petid: g_petid, recall: $("#confirm_recall").val(), doctor: $("#confirm_doctor").val(), vacid: g_vacid, diseaseid: g_disease},
      (data, status) => {
				data = JSON.parse(data);

				if (data["status"]) {
					$("#vac_panel").fadeOut();
					$("#reman").hide();
					$("#recall_" + g_index).remove();
					g_vacid = -1;
					g_disease = -1;
					g_petid = -1;
					g_index = -1;
				} else {

				}
			}
    )
  }

  function recall(index, vacid, petid, diseaseid) {
    $("#reman").fadeIn();
    $("#vac_panel").fadeIn();
    $.post(
			link,
      {action: "getrecall", vacid: vacid, diseaseid: diseaseid},
      (data, status) => {
				data = JSON.parse(data);
				g_vacid = vacid
				g_disease = diseaseid
				g_petid = petid
				g_index = index
				if (data["status"]) {
					$("#confirm_recall").val(data["data"]["recall"]);
					$("#confirm_doctor").val(data["data"]["doctor"]);
					$("#confirm_recall").attr("disabled", true);
					$("#confirm_doctor").attr("disabled", true);
				} else {
					var now = new Date(Number(new Date()) + 3 * 7 * 24 * 60 * 60 * 1000);
					timestring = now.getFullYear() + "-" + (((now.getMonth() + 1) < 10 ? "0" : "") + (now.getMonth() + 1)) + "-" + (now.getDate() < 10 ? "0" : "") + now.getDate();
					var html = "";

					$("#confirm_recall").val(timestring);
					data["data"].forEach((doctor, index) => {
						html += "<option value='" + index + "'>" + doctor["doctor"] + "</option>";
					})
					$("#confirm_doctor").html(html);
					$("#confirm_recall").attr("disabled", false);
					$("#confirm_doctor").attr("disabled", false);
				}
			}
    )
  }

  function editNote(index, diseaseid) {
    var answer = prompt("Ghi chú: ", trim($("#note_v" + diseaseid + "_" + index).text()));
    if (answer) {
      $.post(
        link,
        {action: "editNote", note: answer, id: index, diseaseid: diseaseid},
        (data, status) => {
          data = JSON.parse(data);
          if(data["status"]) {
            $("#note_v" + diseaseid + "_" + index).text(answer);
          }
        }
      )
    }
  }

  function viewNote(index, diseaseid) {
    $("#note_" + diseaseid + "_" + index).toggle(500);
  }

</script>
<!-- END: main -->