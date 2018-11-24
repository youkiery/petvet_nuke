<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify"></div>
<div id="reman"></div>
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
      {lang.doctor}: 
      <span id="doctor"></span>
    </p>
  </div>
  <div class="lieutrinh">
    <input type="date" id="ngaylieutrinh" value="{now}" />
    <button onclick="themlieutrinh()">
      {lang.add}
    </button>
    <span id="lieutrinh" style="float: right;"></span>
    <div id="dslieutrinh">
      
    </div>
    <div id="lieutrinh">
      <form onsubmit="return luulieutrinh(event)" id="qllieutrinh">
        <input class="input" type="text" id="nhietdo" placeholder="{lang.nhietdo}">
        <input class="input" type="text" id="niemmac" placeholder="{lang.niemmac}">
        <input class="input" type="text" id="khac" placeholder="{lang.khac}">
        <input class="input" type="text" id="dieutri" placeholder="{lang.dieutri}">
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
        <button>
          {lang.submit}
        </button>
      </form>
    </div>
  </div>

  <button class="button" style="position: absolute; bottom: 26px; left: 10px;" onclick="ketthuc(1)">
    {lang.trihet}
  </button>
  <button class="button" style="position: absolute; bottom: 26px; left: 110px;" onclick="ketthuc(2)">
    {lang.dachet}
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
  var ltid = -1;
  var d_lieutrinh = []
  var g_ketqua = -1;
  $("#reman").click(() => {
    $("#vac_info").fadeOut();
    $("#reman").hide();
  })

  $("tbody tr").click((e) => {
    lid = e.currentTarget.getAttribute("id");

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
          // console.log(data["lieutrinh"]);
          
          if (data["lieutrinh"]) {
            select = -1;
            d_lieutrinh = data["lieutrinh"]
            $("#dslieutrinh").html("")
            data["lieutrinh"].forEach(e => {
              select ++
              var ngay = e["ngay"] * 1000;
              // console.log(ngay);
              ltid = e["id"]
              html = "<span onclick='xemlieutrinh(" + select + ")'>" + e["ngay"] + "</span> ";
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
          }
          else {
            // console.log("1");
            
            $("#qllieutrinh input").attr("disabled", "disabled");
            $("#qllieutrinh select").attr("disabled", "disabled");
          }

        }
      }
    )
  })

  function themlieutrinh() {
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
            id = d_lieutrinh.length - 1
            $("#nhietdo").val(d_lieutrinh[id]["nhietdo"])
            $("#niemmac").val(d_lieutrinh[id]["niemmac"])
            $("#khac").val(d_lieutrinh[id]["khac"])
            $("#dieutri").val(d_lieutrinh[id]["dieutri"])
            $("#xetnghiem").val(d_lieutrinh[id]["xetnghiem"])
            $("#lieutrinh").text(d_lieutrinh[id]["ngay"])
            $("#tinhtrang2").val(d_lieutrinh[id]["tinhtrang"])

            html = "<span onclick='xemlieutrinh(" + id + ")'>" + data["ngay"] + "</span>";
            $("#dslieutrinh").html($("#dslieutrinh").html() + html)
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

  function xemlieutrinh(id) {
    ltid = id;
    // console.log(d_lieutrinh);
    
    $("#nhietdo").val(d_lieutrinh[id]["nhietdo"])
    $("#niemmac").val(d_lieutrinh[id]["niemmac"])
    $("#khac").val(d_lieutrinh[id]["khac"])
    $("#dieutri").val(d_lieutrinh[id]["dieutri"])
    $("#xetnghiem").val(d_lieutrinh[id]["xetnghiem"])
    $("#lieutrinh").text(d_lieutrinh[id]["ngay"])
    $("#tinhtrang2").val(d_lieutrinh[id]["tinhtrang"])
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
    // console.log(tinhtrang);
    
    $.post(
      link + "luubenh",
      {action: "luulieutrinh", id: ltid, nhietdo: nhietdo, niemmac: niemmac, khac: khac, xetnghiem: xetnghiem, dieutri: dieutri, tinhtrang: tinhtrang},
      (response, status) => {
        response = JSON.parse(response);
        // console.log(response);
        if (response["status"]) {
          $("#" + lid).css("background", response["data"]["color"])
          $("#" + lid + " .suckhoe").text(response["data"]["tinhtrang"])
        }
      }
    )    
  }
</script>
<!-- END: main -->