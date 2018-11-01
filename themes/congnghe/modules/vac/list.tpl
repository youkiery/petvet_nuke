<!-- BEGIN: main -->
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
  var g_index = -1;
  var g_vacid = -1;
  var g_disease = -1;
  var g_petid = -1;
  $("#reman").click(() => {
    $("#vac_panel").fadeOut();
    $("#reman").hide();
  })

  function confirm_upper(index, vacid, petid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link + "confirm&act=up&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      response = JSON.parse(response);
      change_color(value, response["data"], index, vacid, petid, diseaseid);
    })
  }

  function confirm_lower(index, vacid, petid, diseaseid) {
    var value = document.getElementById("vac_confirm_" + index);
    fetch(link + "confirm&act=low&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
      response = JSON.parse(response);
      change_color(value, response["data"], index, vacid, petid, diseaseid);
    })
  }

  function change_color(e, value, index, vacid, petid, diseaseid) {
    check = 0;

    switch (value) {
      case "Đã gọi":
        color = "orange";
        check = 1;
        break;
      case "Đã tiêm":
        color = "green";
        check = 2;
        break;
      case "Chưa gọi":
        color = "red";
        check = 3;
        break;
    }
    if (check) {
      e.innerText = value;
      e.style.color = color;
    }
    if (check === 1) {
      $("#recall_" + index).remove();
    } else if (check == 2) {
      e.parentElement.innerHTML += "<button id='recall_" + index + "' onclick='recall(" + index + ", " + vacid + ", " + petid + ", " + diseaseid +")'>Tái chủng</button>";
    }
  }

  function save_form() {
    $.post(
      link + "main&act=post",
      {action: "save", petid: g_petid, recall: $("#confirm_recall").val(), doctor: $("#confirm_doctor").val(), vacid: g_vacid, diseaseid: g_disease},
      (data, status) => {
        data = JSON.parse(data);
        console.log(data);
        
        if (data["status"]) {
          $("#vac_panel").fadeOut();
          $("#reman").hide();
          console.log(g_index);
          
          $("#recall_" + g_index).remove();
          g_vacid = -1;
          g_disease = -1;
          g_petid = -1;
          g_index = -1;
        }
        else {
          
        }
      }
    )
  }

  function recall(index, vacid, petid, diseaseid) {
    $("#reman").fadeIn();
    $("#vac_panel").fadeIn();
    $.post(link + "main&act=post",
      {action: "getrecall", vacid: vacid, diseaseid: diseaseid},
      (data, status) => {
        data = JSON.parse(data);
        console.log(data);
        g_vacid = vacid
        g_disease = diseaseid
        g_petid = petid
        g_index = index
        if(data["status"]) {
          $("#confirm_recall").val(data["data"]["recall"]);
          $("#confirm_doctor").val(data["data"]["doctor"]);
          $("#confirm_recall").attr("disabled", true);
          $("#confirm_doctor").attr("disabled", true);
        }
        else {
          var now = new Date(Number(new Date()) + 3 * 24 * 60 * 60 * 1000);
          timestring = now.getFullYear() + "-" + (((now.getMonth() + 1) < 10 ? "0" : "") + (now.getMonth() + 1)) + "-" + (now.getDate() < 10 ? "0" : "") + now.getDate();
          var html = "";
          
          $("#confirm_recall").val(timestring);
          data["data"].forEach((doctor, index) => {
            html += "<option value='" + index +"'>" + doctor["doctor"] + "</option>";            
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
    var fromtime = document.getElementById("f_fromtime").value;
    var time_amount = document.getElementById("f_moment").value;
    var sort = document.getElementById("f_sort").value;
    fetch(link + "search&key=" + key + "&fromtime=" + fromtime + "&time_amount=" + time_amount + "&sort=" + sort, []).then(response => {
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