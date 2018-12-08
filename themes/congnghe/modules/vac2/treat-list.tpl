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
      {lang.ngayluubenh}: 
      <span id="luubenh"></span>
    </p>
    <p>
      {lang.doctor2}: 
      <span id="doctor"></span>
    </p>
  </div>
  <div class="lieutrinh">
    <span id="lieutrinh" style="float: right;"></span>
    <form onsubmit="return themlieutrinh(event)">
      <input type="date" id="ngaylieutrinh" value="{now}" />
      <button class="submitbutton">
        {lang.add}
      </button>
    </form>
    <div id="dslieutrinh">
      
    </div>
    <div id="lieutrinh">
      <form onsubmit="return luulieutrinh(event)" id="qllieutrinh">
        <input class="input" type="text" id="nhietdo" placeholder="{lang.nhietdo}">
        <input class="input" type="text" id="niemmac" placeholder="{lang.niemmac}">
        <input class="input" type="text" id="khac" placeholder="{lang.khac}">
        <input class="input" type="text" id="dieutri" placeholder="{lang.dieutri}">
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
        <label for="tinhtrang">{lang.tinhtrang}</label>
        <select name="tinhtrang" id="tinhtrang2"> 
          <!-- BEGIN: status_option -->
          <option value="{status_value}"> {status_name} </option>
          <!-- END: status_option -->
        </select>
        <br>
        <label for="xetnhiem">{lang.xetnghiem}</label>
        <select name="xetnghiem" id="xetnghiem"> 
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
  <button class="button submitbutton" style="position: absolute; bottom: 26px; left: 210px;" onclick="tongket()">
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
<!-- BEGIN: main -->
<table class="vng_vacbox tab1">
  <thead>
    <tr>
      <th style="width: 20px;">
        {lang.index}
      </th>  
      <th style="width: 100px;">
        {lang.petname}
      </th>
      <th style="width: 100px;">
        {lang.customer}
      </th>
      <th style="width: 100px;">
        {lang.doctor2}
      </th>  
      <th style="width: 50px;">
        {lang.ngayluubenh}
      </th>
      <th style="width: 50px;">
        {lang.tinhtrang}
      </th>
      <th style="width: 50px;">
        {lang.ketqua}
      </th>
    </tr>
  </thead>
  <tbody>
    <!-- BEGIN: list -->  
    <tr style="text-transform: capitalize; background: {bgcolor}" id="{lid}">
      <td>
        {index}
      </td>    
      <td class="petname">
        {petname}
      </td>
      <td class="petname">
        {customer}
      </td>    
      <td class="doctor">
        {doctor}
      </td>
      <td class="luubenh">
        {luubenh}
      </td>
      <td class="suckhoe">
        {tinhtrang}
      </td>
      <td class="tinhtrang">
        {ketqua}
      </td>
      <td style="display: none;" class="lieutrinh">
        {lieutrinh}
      </td>
    </tr>
    <!-- END: list -->
  </tbody>
</table>
<!-- END: main -->
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
  var lid = -1;
  var g_ltid = -1;
  var g_id = -1;
  var d_lieutrinh = []
  var g_ketqua = -1;
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
          $("#luubenh").text(data["ngayluubenh"])
          $("#doctor").text(data["doctor"])
          var h_lieutrinh = ""
          g_ketqua = data["ketqua"];
          // console.log(data);
          
          if (data["lieutrinh"]) {
            // console.log(data["ketqua"]);
            
            if (data["ketqua"] > 0) {
              $("#qllieutrinh input").attr("disabled", "disabled");
              $("#qllieutrinh select").attr("disabled", "disabled");
              $(".submitbutton").attr("disabled", "disabled");
            }
            else {
              $("#qllieutrinh input").removeAttr("disabled", "");
              $("#qllieutrinh select").removeAttr("disabled", "");
              $(".submitbutton").removeAttr("disabled", "");
            }
            select = -1;
            d_lieutrinh = data["lieutrinh"]
            $("#dslieutrinh").html("")
            data["lieutrinh"].forEach(e => {
              select ++
              var ngay = e["ngay"] * 1000;
              // console.log(ngay);
              g_ltid = e["id"]
              g_id = select
              html = "<span onclick='xemlieutrinh(" + g_ltid + ", " + select +")'>" + e["ngay"] + "</span> ";
              $("#dslieutrinh").html($("#dslieutrinh").html() + html)
            })
            // console.log(select, data["lieutrinh"]);
            
            $("#nhietdo").val(data["lieutrinh"][select]["nhietdo"])
            $("#niemmac").val(data["lieutrinh"][select]["niemmac"])
            $("#khac").val(data["lieutrinh"][select]["khac"])
            $("#dieutri").val(data["lieutrinh"][select]["dieutri"])
            $("#xetnghiem").val(data["lieutrinh"][select]["xetnghiem"])
            $("#lieutrinh").text(data["lieutrinh"][select]["ngay"])
            $("#tinhtrang2").val(data["lieutrinh"][select]["tinhtrang"])
            $("#doctorx").val(data["lieutrinh"][select]["doctorx"])
          }
          else {
            // console.log("2");
            d_lieutrinh = []
            $("#qllieutrinh input").attr("disabled", "disabled");
            $("#qllieutrinh select").attr("disabled", "disabled");
            $("#dslieutrinh").html("")
            
            $("#nhietdo").val("")
            $("#niemmac").val("")
            $("#khac").val("")
            $("#dieutri").val("")
            $("#xetnghiem").val(0)
            $("#lieutrinh").text("")
            $("#tinhtrang2").val(0)
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
    var addition = "<p><b>{lang.tongngay} " + d_lieutrinh.length + " </b></p>"
    d_lieutrinh.forEach((lieutrinh, index) => {
      body += "<tr style='height: 32px;'><td style='width: 20%'>" + lieutrinh["ngay"] + "</td><td style='width: 50%'><b>{lang.nhietdo}</b>: " + lieutrinh["nhietdo"] + "<br><b>{lang.niemmac}</b>: " + lieutrinh["niemmac"] + "<br><b>{lang.khac}</b>: " + lieutrinh["khac"] + "</td><td style='width: 30%'>" + lieutrinh["dieutri"] + "</td></tr>"
    }) 
    var html = 
    "<table border='1' style='border-collapse: collapse; width: 100%;'><thead><tr style='height: 32px;'><th><span id='tk_khachhang'>" + $("#customer").text() + "</span> / <span id='tk_thucung'>" + $("#petname").text() + "</span></th><th>{lang.trieuchung}</th><th>{lang.dieutri}</th></tr></thead><tbody>" + body + "</tbody><tfoot><tr><td colspan='3'>" + addition + "</td></tr></tfoot></table>"
    $("#vac2_body").html(html)
  }

  function themlieutrinh(e) {
    e.preventDefault();
    $.post(
      link + "luubenh",
      {action: "themlieutrinh", ngay: $("#ngaylieutrinh").val(), id: lid},
      (response, status) => {
        response = JSON.parse(response)
        // console.log(response)
        switch (response["status"]) {
          case 1:
            // thành công
            var data = response["data"]
            d_lieutrinh.push(data)
            // console.log(d_lieutrinh);
            
            id = d_lieutrinh.length - 1
            g_ltid = data["id"]
            g_id = id
            $("#nhietdo").val(d_lieutrinh[id]["nhietdo"])
            $("#niemmac").val(d_lieutrinh[id]["niemmac"])
            $("#khac").val(d_lieutrinh[id]["khac"])
            $("#dieutri").val(d_lieutrinh[id]["dieutri"])
            $("#xetnghiem").val(d_lieutrinh[id]["xetnghiem"])
            $("#lieutrinh").text(d_lieutrinh[id]["ngay"])
            $("#tinhtrang2").val(d_lieutrinh[id]["tinhtrang"])
            $("#doctorx").val(d_lieutrinh[id]["doctorx"])

            html = "<span onclick='xemlieutrinh(" + d_lieutrinh[id]["id"] + ", " + g_id + ")'>" + data["ngay"] + "</span>";
            $("#dslieutrinh").html($("#dslieutrinh").html() + html)
            $("#qllieutrinh input").removeAttr("disabled", "");
            $("#qllieutrinh select").removeAttr("disabled", "");
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

  function xemlieutrinh(ltid, id) {
    g_ltid = ltid;
    g_id = id;
    // console.log(g_ltid);
    // console.log(d_lieutrinh);
    
    $("#nhietdo").val(d_lieutrinh[id]["nhietdo"])
    $("#niemmac").val(d_lieutrinh[id]["niemmac"])
    $("#khac").val(d_lieutrinh[id]["khac"])
    $("#dieutri").val(d_lieutrinh[id]["dieutri"])
    $("#xetnghiem").val(d_lieutrinh[id]["xetnghiem"])
    $("#lieutrinh").text(d_lieutrinh[id]["ngay"])
    $("#tinhtrang2").val(d_lieutrinh[id]["tinhtrang"])
    $("#doctorx").val(d_lieutrinh[id]["doctorx"])
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
          $("#" + lid + " .tinhtrang").text(response["data"]["ketqua"])
          $("#vac_info").fadeOut();
          $("#reman").hide();
        }
      }
    )    
  }

  function luulieutrinh(e) {
    e.preventDefault();
    var nhietdo = $("#nhietdo").val();
    // console.log(nhietdo);
    var niemmac = $("#niemmac").val();
    // console.log(niemmac);
    var khac = $("#khac").val();
    // console.log(khac);
    var xetnghiem = $("#xetnghiem").val();
    // console.log(xetnghiem);
    var dieutri = $("#dieutri").val();
    // console.log(dieutri);
    var tinhtrang = $("#tinhtrang2").val();
    var doctorx = $("#doctorx").val();
    // console.log(tinhtrang);
    
    $.post(
      link + "luubenh",
      {action: "luulieutrinh", id: g_ltid, nhietdo: nhietdo, niemmac: niemmac, khac: khac, xetnghiem: xetnghiem, dieutri: dieutri, tinhtrang: tinhtrang, doctorx: doctorx},
      (response, status) => {
        response = JSON.parse(response);
        console.log(response);
        if (response["status"]) {
          alert_msg("Đã lưu");
          $("#" + lid).css("background", response["data"]["color"])
          $("#" + lid + " .suckhoe").text(response["data"]["tinhtrang"])
          d_lieutrinh[g_id]["nhietdo"] = nhietdo
          d_lieutrinh[g_id]["niemmac"] = niemmac
          d_lieutrinh[g_id]["khac"] = khac
          d_lieutrinh[g_id]["xetnghiem"] = xetnghiem
          d_lieutrinh[g_id]["dieutri"] = dieutri
          d_lieutrinh[g_id]["tinhtrang"] = tinhtrang
          d_lieutrinh[g_id]["doctorx"] = doctorx
        }
      }
    )    
  }
</script>
<!-- END: main -->