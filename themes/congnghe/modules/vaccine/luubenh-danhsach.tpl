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
      {lang.cometime}: 
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
        <input class="input" type="text" id="temperate" placeholder="{lang.temperate}">
        <input class="input" type="text" id="rate" placeholder="{lang.rate}">
        <input class="input" type="text" id="other" placeholder="{lang.other}">
        <input class="input" type="text" id="treating" placeholder="{lang.treating}">
        <br>
        <label for="doctorx">{lang.doctor}</label>
        <select name="doctorx" id="doctorx"> 
          <!-- BEGIN: doctor -->
          <option value="{doctorid}"> {doctorname} </option>
          <!-- END: doctor -->
        </select>
        <button class="submitbutton">
          {lang.submit}
        </button>
        <br>
        <label for="status">{lang.status}</label>
        <select name="status" id="status2"> 
          <!-- BEGIN: status_option -->
          <option value="{status_value}"> {status_name} </option>
          <!-- END: status_option -->
        </select>
        <br>
        <label for="xetnhiem">{lang.examine}</label>
        <select name="examine" id="examine"> 
          <option value="0"> {lang.non} </option>
          <option value="1"> {lang.have} </option>
        </select>
      </form>
    </div>
  </div>

  <button class="button submitbutton" style="position: absolute; bottom: 26px; left: 10px;" onclick="ketthuc(1)">
    {lang.trihet}
  </button>
  <button class="button submitbutton" style="position: absolute; bottom: 26px; left: 110px;" onclick="ketthuc(2)">
    {lang.dachet}
  </button>
  <button class="button" style="position: absolute; bottom: 26px; left: 210px;" onclick="tongket()">
    {lang.tongket}
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
    // console.log(e);
    if (e.key == "Escape") {
      closeVac()
    }
  })

  function closeVac() {
    // console.log(vac_index);
    
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
          // console.log(data);
          $("#petname").text(data["petname"])
          $("#customer").text(data["customer"])
          $("#phone").text(data["phone"])
          $("#luubenh").text(data["cometime"])
          $("#doctor").text(data["doctor"])
          var h_treating = ""
          g_insult = data["insult"];
          // console.log(data);
          
          if (data["treating"]) {
            // console.log(data["insult"]);
            
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
              // console.log(time);
              g_ltid = e["id"]
              g_id = select
              html = "<span onclick='xemtreating(" + g_ltid + ", " + select +")'>" + e["time"] + "</span> ";
              $("#dstreating").html($("#dstreating").html() + html)
            })
            // console.log(select, data["treating"]);
            
            $("#temperate").val(data["treating"][select]["temperate"])
            $("#rate").val(data["treating"][select]["rate"])
            $("#other").val(data["treating"][select]["other"])
            $("#treating").val(data["treating"][select]["treating"])
            $("#examine").val(data["treating"][select]["examine"])
            $("#treating").text(data["treating"][select]["time"])
            $("#status2").val(data["treating"][select]["status"])
            $("#doctorx").val(data["treating"][select]["doctorx"])
          }
          else {
            // console.log("2");
            d_treating = []
            $("#qltreating input").attr("disabled", "disabled");
            $("#qltreating select").attr("disabled", "disabled");
            $("#dstreating").html("")
            
            $("#temperate").val("")
            $("#rate").val("")
            $("#other").val("")
            $("#treating").val("")
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
    var addition = "<p><b>{lang.tongtime} " + d_treating.length + " </b></p>"
    d_treating.forEach((treating, index) => {
      body += "<tr style='height: 32px;'><td style='width: 20%'>" + treating["time"] + "</td><td style='width: 50%'><b>{lang.temperate}</b>: " + treating["temperate"] + "<br><b>{lang.rate}</b>: " + treating["rate"] + "<br><b>{lang.other}</b>: " + treating["other"] + "</td><td style='width: 30%'>" + treating["treating"] + "</td></tr>"
    }) 
    var html = 
    "<table border='1' style='border-collapse: collapse; width: 100%;'><thead><tr style='height: 32px;'><th><span id='tk_otherhhang'>" + $("#customer").text() + "</span> / <span id='tk_thucung'>" + $("#petname").text() + "</span></th><th>{lang.trieuchung}</th><th>{lang.treating}</th></tr></thead><tbody>" + body + "</tbody><tfoot><tr><td colspan='3'>" + addition + "</td></tr></tfoot></table>"
    $("#vac2_body").html(html)
  }

  function themtreating(e) {
    e.preventDefault();
    $.post(
      link + "luubenh",
      {action: "themtreating", time: $("#timetreating").val(), id: lid},
      (response, status) => {
        response = JSON.parse(response)
        // console.log(response)
        switch (response["status"]) {
          case 1:
            // thành công
            var data = response["data"]
            d_treating.push(data)
            // console.log(d_treating);
            
            id = d_treating.length - 1
            g_ltid = data["id"]
            g_id = id
            $("#temperate").val(d_treating[id]["temperate"])
            $("#rate").val(d_treating[id]["rate"])
            $("#other").val(d_treating[id]["other"])
            $("#treating").val(d_treating[id]["treating"])
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
    // console.log(g_ltid);
    // console.log(d_treating);
    
    $("#temperate").val(d_treating[id]["temperate"])
    $("#rate").val(d_treating[id]["rate"])
    $("#other").val(d_treating[id]["other"])
    $("#treating").val(d_treating[id]["treating"])
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
        // console.log(response);
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
    // console.log(temperate);
    var rate = $("#rate").val();
    // console.log(rate);
    var other = $("#other").val();
    // console.log(other);
    var examine = $("#examine").val();
    // console.log(examine);
    var treating = $("#treating").val();
    // console.log(treating);
    var status = $("#status2").val();
    var doctorx = $("#doctorx").val();
    // console.log(status);
    
    $.post(
      link + "luubenh",
      {action: "luutreating", id: g_ltid, temperate: temperate, rate: rate, other: other, examine: examine, treating: treating, status: status, doctorx: doctorx},
      (response, status) => {
        response = JSON.parse(response);
        console.log(response);
        if (response["status"]) {
          alert_msg("Đã lưu");
          $("#" + lid).css("background", response["data"]["color"])
          $("#" + lid + " .suckhoe").text(response["data"]["status"])
          d_treating[g_id]["temperate"] = temperate
          d_treating[g_id]["rate"] = rate
          d_treating[g_id]["other"] = other
          d_treating[g_id]["examine"] = examine
          d_treating[g_id]["treating"] = treating
          d_treating[g_id]["status"] = status
          d_treating[g_id]["doctorx"] = doctorx
        }
      }
    )    
  }
</script>
<!-- END: main -->