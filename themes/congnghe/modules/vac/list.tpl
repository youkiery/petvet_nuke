<!-- BEGIN: overtime -->
<p>
  Đã hết thời gian làm việc, xin hãy quay trở lại vào ngày mai!  
</p>

<!-- END: overtime -->
<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<div id="reman" style="display: none; background: black; opacity: 0.5; position: fixed; width: 100%; height: 100%; top: 0; left: 0;"></div>
<div id="vac_panel" style="display: none; position: fixed; margin:auto;">
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
<form class="vac_form" onsubmit="return search()">
  <input type="text" id="customer_key" class="vac_input">
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<div id="disease_display">
  {content}
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=";
  var g_index = -1;
  var g_vacid = -1;
  var g_disease = -1;
  var g_petid = -1;
  $("#reman").click(() => {
    $("#vac_panel").fadeOut();
    $("#reman").hide();
  })

  function confirm_upper(index, vacid, petid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + diseaseid + "_" + index);
    fetch(link + "confirm&act=up&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      response = JSON.parse(response);
      change_color(value, response, index, vacid, petid, diseaseid);
    })
  }

  function confirm_lower(index, vacid, petid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + diseaseid + "_" + index);
    fetch(link + "confirm&act=low&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      response = JSON.parse(response);
      change_color(value, response, index, vacid, petid, diseaseid);
    })
  }

  function change_color(e, response, index, vacid, petid, diseaseid) {
    if (response["status"]) {
      e.innerText = response["data"]["value"];
      e.style.color = response["data"]["color"];
      if (response["data"]["color"] == "green" && response["data"]["recall"]) {
        e.parentElement.innerHTML += "<button id='recall_" + index + "' onclick='recall(" + index + ", " + vacid + ", " + petid + ", " + diseaseid + ")'>Tái chủng</button>";
      } else {
        $("#recall_" + index).remove();
      }
    }
  }

  function save_form() {
    $.post(
      link + "main&act=post",
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
			link + "main&act=post",
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

  function search() {

    var key = document.getElementById("customer_key").value;
    fetch(link + "search&key=" + key, []).then(response => {
      document.getElementById("disease_display").innerHTML = response;
    })
    return false;
  }

  function editNote(index, diseaseid) {
    var answer = prompt("Ghi chú: ", trim($("#note_v" + diseaseid + "_" + index).text()));
    if (answer) {
      $.post(
        link + "main&act=post",
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