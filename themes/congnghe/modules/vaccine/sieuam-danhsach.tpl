<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify"></div>
<div id="reman"></div>
<div id="vac_info2" style="display:none;">
  <form onsubmit="return onbirth(event)">
    <table style="width: 100%; line-height: 56px;">
      <thead>
        <tr>
          <th colspan="2">
            {lang.usgrecall}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {lang.usgnumber}
          </td>
          <td>
            <input type="number" id="birthnumber">
          </td>
        </tr>
        <tr>
          <td>
            {lang.usgbirthday}
          </td>
          <td>
            <input type="date" id="birthday">
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;">
            <button>
              {lang.save}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<div id="vac_info" style="display:none;">
  <div id="thumb-box">
    <img id="thumb" src="{image}">
  </div>
  <div id="info">
    <p>
      {lang.petname}: 
      <span id="petname"></span>
    </p>
    <p>
      {lang.customer}: 
      <span id="customer"></span>
    </p>
    <p>
      {lang.phone}: 
      <span id="phone"></span>
    </p>
    <p>
      {lang.usgcome}: 
      <span id="sieuam"></span>
    </p>
    <p>
      {lang.usgcall}: 
      <span id="dusinh"></span>
    </p>
  </div>
</div>
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
<div id="disease_display">
  {content}
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
  var g_index = -1
  var g_id = -1
  var g_petid = -1

  function confirm_lower(index, vacid, petid) {
    var e = document.getElementById("vac_confirm_" + index);
    $.post(
      link + "xacnhansieuam",
      {act: "down", value: trim(e.innerText), id: vacid},
      (data, status) => {
        data = JSON.parse(data);
        change_color(e, data, index, vacid, petid);
      }
    )
  }

  function confirm_upper(index, vacid, petid) {
    var e = document.getElementById("vac_confirm_" + index);
    $.post(
      link + "xacnhansieuam",
      {act: "up", value: trim(e.innerText), id: vacid},
      (data, status) => {
        data = JSON.parse(data);
        change_color(e, data, index, vacid, petid);
      }
    )
  }

  function change_color(e, response, index, vacid, petid) {
    if (response["status"]) {
      e.innerText = response["data"]["value"];
      e.style.color = response["data"]["color"];
      var check = response["data"].hasOwnProperty("birth");
      if (check) {
        if (response["data"]["color"] == "green") {
          $("#birth_" + index).html("<button id='birth_" + index + "' onclick='birth(" + index + ", " + vacid + ", " + petid + ")'> " + response["data"]["birth"] + "</button>");
        }
        else if (response["data"]["color"] == "dodgerblue") {
          $("#birth_" + index).html("<button id='birth_" + index + "' onclick='exbirth(" + index + ", " + vacid + ", " + petid + ")'> " + response["data"]["birth"] + "</button>");
        }
      } else {
        $("#birth_" + index).html("");
      }
    }
  }

  function editNote(index) {
    var answer = prompt("Ghi chú: ", trim($("#note_v" + index).text()));
    if (answer) {
      $.post(
        link + "sieuam&act=post",
        {action: "editNote", note: answer, id: index},
        (data, status) => {
          data = JSON.parse(data);
          if(data["status"]) {
            $("#note_v" + index).text(answer);
          }
        }
      )
    }
  }

  function viewNote(index) {
    $("#note_" + index).toggle(500);
  }

  function birth(index, vacid, petid) {
    $("#birthnumber").val("")
    $("#birthday").val("")
    $("#vac_info2").fadeIn();
    $("#reman").show();

    g_index = index
    g_id = vacid
    g_petid = petid
  }

  function exbirth(index, vacid, petid) {
    var exbirth_val = prompt("Dự đoán được bao nhiêu thai", 1)
    if (exbirth_val) {
      $.post(
        link + "sieuam",
        {action: "exbirth", id: vacid, petid: petid, birth: exbirth_val},
        (response, status) => {
          data = JSON.parse(response);
          if (data["status"]) {
            var x = $("#birth_" + index).children()[0]
            x.innerText = data["birth"]
          }
        }
      )
    }
  }

  function onbirth(event) {
    event.preventDefault()
      $.post(
        link + "sieuam",
        {action: "birth", id: g_id, petid: g_petid, birth: $("#birthnumber").val(), birthday: $("#birthday").val()},
        (response, status) => {
          data = JSON.parse(response);
          if (data["status"]) {
            $("#birth_" + g_index).text(data["data"]["birth"])
            // $("#birth_" + g_index).attr("disabled", "true")
            g_index = -1
            g_id = -1
            g_petid = -1
            iclose();
          }
        }
      )
  }

  $("body").keydown((e) => {
    if (e.key == "Escape") {
      iclose()
    }
  })


  $("#reman").click(() => {
    iclose();
  })

  function iclose() {
    $("#vac_info").fadeOut();
    $("#vac_info2").fadeOut();
    $("#reman").hide();
  }

  $("tbody td[class]").click((e) => {
    var data_collect = e.target.parentElement.children;
    var image = e.currentTarget.parentElement.getAttribute("img");
    $("#vac_info").fadeIn();
    $("#reman").show();

    var c = document.createElement("canvas")
    var ctx = c.getContext("2d");
    var img = new Image()
    img.src = image
    img.onload = () => {
      c.width = img.width
      c.height = img.height
      ctx.fillStyle = "#fff"
      ctx.fillRect(0, 0, c.width, c.height)
      ctx.drawImage(img, 0, 0)
      var image_data = c.toDataURL("image/jpg")
      $("#thumb").attr("src", image_data);
    }

    $("#thumb").attr("src", "");
    $("#petname").text(data_collect[1].innerText);
    $("#customer").text(data_collect[2].innerText);
    $("#phone").text(data_collect[3].innerText);
    $("#sieuam").text(data_collect[4].innerText);
    $("#dusinh").text(data_collect[5].innerText);
  })


</script>
<!-- END: main -->