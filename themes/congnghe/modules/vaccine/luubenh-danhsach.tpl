<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify"></div>
<div id="reman"></div>
<div id="vac_info2" style="display:none;">
  <div id="vac2_header"></div>
  <div id="vac2_body"></div>
</div>
<div id="vac_info" style="display:none;">
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
      {lang.treatcome}: 
      <span id="luubenh"></span>
    </p>
    <p>
      {lang.doctor2}: 
      <span id="doctor"></span>
    </p>
  </div>
  <div class="treating">
    <span id="treating" style="float: right;"></span>
    <form onsubmit="return themtreating(event)">
      <input type="date" id="timetreating" value="{now}" />
      <button class="submitbutton">
        {lang.add}
      </button>
    </form>
    <div id="dstreating">
      
    </div>
    <div id="treating">
      <form onsubmit="return luutreating(event)" id="qltreating">
        <div style="font-size:0px;">
          <input class="input" type="text" id="temperate" placeholder="{lang.temperate}">
          <input class="input" type="text" id="eye" placeholder="{lang.eye}">
          <input class="input" type="text" id="other" placeholder="{lang.other}">
          <input class="input" type="text" id="treating2" placeholder="{lang.treating}">
        </div>
        <div>
          <label for="doctorx">{lang.doctor}</label>
          <select name="doctorx" id="doctorx"> 
            <!-- BEGIN: doctor -->
            <option value="{doctorid}"> {doctorname} </option>
            <!-- END: doctor -->
          </select>
        </div>
        <div>
          <label for="status">{lang.status}</label>
          <select name="status" id="status2"> 
            <!-- BEGIN: status_option -->
            <option value="{status_value}"> {status_name} </option>
            <!-- END: status_option -->
          </select>
        </div>
        <div>
          <label for="xetnhiem">{lang.examine}</label>
          <select name="examine" id="examine"> 
            <option value="0"> {lang.non} </option>
            <option value="1"> {lang.have} </option>
          </select>
        </div>
        <button class="submitbutton">
          {lang.submit}
        </button>
      </form>
    </div>
  </div>

  <button class="button submitbutton" style="position: absolute; bottom: 26px; left: 10px;" onclick="ketthuc(1)">
    {lang.treated}
  </button>
  <button class="button submitbutton" style="position: absolute; bottom: 26px; left: 110px;" onclick="ketthuc(2)">
    {lang.dead}
  </button>
  <button class="button" style="position: absolute; bottom: 26px; left: 210px;" onclick="tongket()">
    {lang.summary}
  </button>
</div>
<!-- <form class="vac_form" method="GET">
  <input type="hidden" name="nv" value="vac">
  <input type="hidden" name="op" value="danhsachsieuam">
  <input type="text" name="key" value="{keyword}" class="vac_input">
  <input type="submit" class="vac_button" value="{lang.search}">
</form> -->
<div id="disease_display">
  {content}
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
  var lid = -1;
  var g_ltid = -1;
  var g_id = -1;
  var d_treating = []
  var g_insult = -1;
  var vac_index = 0;
  $("#reman").click(() => {
    closeVac()
  })

  $("body").keydown((e) => {
    if (e.key == "Escape") {
      closeVac()
    }
  })

  function closeVac() {
    if (vac_index == 1) {
      $("#vac_info").fadeOut();
      $("#reman").hide();
      vac_index = 0;
    }
    if (vac_index == 2) {
      $("#vac_info2").fadeOut();
      vac_index = 1;
    }
  }

  $("tbody tr").click((e) => {
    lid = e.currentTarget.getAttribute("id");
    vac_index = 1;

    $("#vac_info").fadeIn();
    $("#reman").show();

    $.post(
      link + "luubenh",
      {action: "thongtinluubenh", id: lid},
      (response, status) => {
        response = JSON.parse(response)
        if (response["status"]) {
          data = response["data"]
          $("#petname").text(data["petname"])
          $("#customer").text(data["customer"])
          $("#phone").text(data["phone"])
          $("#luubenh").text(data["cometime"])
          $("#doctor").text(data["doctor"])
          var h_treating = ""
          g_insult = data["insult"];
          
          if (data["treating"]) {
            if (data["insult"] > 0) {
              $("#qltreating input").attr("disabled", "disabled");
              $("#qltreating select").attr("disabled", "disabled");
              $(".submitbutton").attr("disabled", "disabled");
            }
            else {
              $("#qltreating input").removeAttr("disabled", "");
              $("#qltreating select").removeAttr("disabled", "");
              $(".submitbutton").removeAttr("disabled", "");
            }
            select = -1;
            d_treating = data["treating"]
            $("#dstreating").html("")
            data["treating"].forEach(e => {
              select ++
              var time = e["time"] * 1000;
              g_ltid = e["id"]
              g_id = select
              html = "<span onclick='xemtreating(" + g_ltid + ", " + select +")'>" + e["time"] + "</span> ";
              $("#dstreating").html($("#dstreating").html() + html)
            })
            $("#temperate").val(data["treating"][select]["temperate"])

            $("#eye").val(data["treating"][select]["eye"])
            $("#other").val(data["treating"][select]["other"])
            $("#treating2").val(data["treating"][select]["treating"])
            $("#examine").val(data["treating"][select]["examine"])
            $("#treating").text(data["treating"][select]["time"])
            $("#status2").val(data["treating"][select]["status"])
            $("#doctorx").val(data["treating"][select]["doctorx"])
          }
          else {
            d_treating = []
            $("#qltreating input").attr("disabled", "disabled");
            $("#qltreating select").attr("disabled", "disabled");
            $("#dstreating").html("")
            
            $("#temperate").val("")
            $("#rate").val("")
            $("#other").val("")
            $("#treating2").val("")
            $("#examine").val(0)
            $("#treating").text("")
            $("#status2").val(0)
            $("#doctorx").val(0)
          }

        }
      }
    )
  })

  function tongket() {
    $("#vac_info2").fadeIn()
    vac_index = 2;

    var body = ""
    var addition = "<p><b>{lang.totaltreat} " + d_treating.length + " </b></p>"
    d_treating.forEach((treating, index) => {
      body += "<tr style='height: 32px;'><td style='width: 20%'>" + treating["time"] + "</td><td style='width: 50%'><b>{lang.temperate}</b>: " + treating["temperate"] + "<br><b>{lang.eye}</b>: " + treating["eye"] + "<br><b>{lang.other}</b>: " + treating["other"] + "</td><td style='width: 30%'>" + treating["treating"] + "</td></tr>"
    }) 
    var html = 
    "<table border='1' style='border-collapse: collapse; width: 100%;'><thead><tr style='height: 32px;'><th><span id='tk_otherhhang'>" + $("#customer").text() + "</span> / <span id='tk_thucung'>" + $("#petname").text() + "</span></th><th>{lang.eviden}</th><th>{lang.treating}</th></tr></thead><tbody>" + body + "</tbody><tfoot><tr><td colspan='3'>" + addition + "</td></tr></tfoot></table>"
    $("#vac2_body").html(html)
  }

  function themtreating(e) {
    e.preventDefault();
    $.post(
      link + "luubenh",
      {action: "themtreating", time: $("#timetreating").val(), id: lid},
      (response, status) => {
        response = JSON.parse(response)
        switch (response["status"]) {
          case 1:
            // thành công
            var data = response["data"]
            d_treating.push(data)
            id = d_treating.length - 1
            g_ltid = data["id"]
            g_id = id
            $("#temperate").val(d_treating[id]["temperate"])
            $("#eye").val(d_treating[id]["eye"])
            $("#other").val(d_treating[id]["other"])
            $("#treating2").val(d_treating[id]["treating"])
            $("#examine").val(d_treating[id]["examine"])
            $("#treating").text(d_treating[id]["time"])
            $("#status2").val(d_treating[id]["status"])
            $("#doctorx").val(d_treating[id]["doctorx"])

            html = "<span onclick='xemtreating(" + d_treating[id]["id"] + ", " + g_id + ")'>" + data["time"] + "</span>";
            $("#dstreating").html($("#dstreating").html() + html)
            $("#qltreating input").removeAttr("disabled", "");
            $("#qltreating select").removeAttr("disabled", "");
          break;
          case 2:
            // đã tồn tại ngày hôm nay
            
          break;
          default:
        }
        // if () {
        // }
      }
    )
  }

  function xemtreating(ltid, id) {
    g_ltid = ltid;
    g_id = id;
    
    $("#temperate").val(d_treating[id]["temperate"])
    $("#eye").val(d_treating[id]["eye"])
    $("#other").val(d_treating[id]["other"])
    $("#treating2").val(d_treating[id]["treating"])
    $("#examine").val(d_treating[id]["examine"])
    $("#treating").text(d_treating[id]["time"])
    $("#status2").val(d_treating[id]["status"])
    $("#doctorx").val(d_treating[id]["doctorx"])
  }

  function ketthuc(val) {
    $.post(
      link + "luubenh",
      {action: "trihet", id: lid, val: val},
      (response, status) => {
        response = JSON.parse(response);
        if (response["status"]) {
          $("#" + lid).css("background", response["data"]["color"])
          $("#" + lid + " .status").text(response["data"]["insult"])
          $("#vac_info").fadeOut();
          $("#reman").hide();
        }
      }
    )    
  }

  function luutreating(e) {
    e.preventDefault();
    var temperate = $("#temperate").val();
    var eye = $("#eye").val();
    var other = $("#other").val();
    var examine = $("#examine").val();
    var treating = $("#treating2").val();
    var status = $("#status2").val();
    var doctorx = $("#doctorx").val();
    
    $.post(
      link + "luubenh",
      {action: "luutreating", id: g_ltid, temperate: temperate, eye: eye, other: other, examine: examine, treating: treating, status: status, doctorx: doctorx},
      (response, status) => {
        response = JSON.parse(response);
        if (response["status"]) {
          alert_msg("Đã lưu");
          $("#" + lid).css("background", response["data"]["color"])
          $("#" + lid + " .suckhoe").text(response["data"]["status"])
          d_treating[g_id]["temperate"] = temperate
          d_treating[g_id]["eye"] = eye
          d_treating[g_id]["other"] = other
          d_treating[g_id]["examine"] = examine
          d_treating[g_id]["treating2"] = treating
          d_treating[g_id]["status"] = status
          d_treating[g_id]["doctorx"] = doctorx
        }
      }
    )    
  }
</script>
<!-- END: main -->