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
<form class="vac_form" method="GET">
  <input type="hidden" name="nv" value="vac">
  <input type="hidden" name="op" value="danhsachsieuam">
  <input type="text" name="key" value="{keyword}" class="vac_input">
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<div id="disease_display">
  {content}
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";

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
    // fetch(link + "confirm&act=up&value=" + trim(value.innerText) + "&vacid=" + vacid + "&diseaseid=" + diseaseid, []).then(response => {
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
    console.log(e, response, index, vacid, petid);
    
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

</script>
<!-- END: main -->