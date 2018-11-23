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
    <div id="dslieutrinh">
      
    </div>
    <div id="lieutrinh">
      <form onsubmit="return luulieutrinh(event)">
        <input class="input" type="text" id="nhietdo" placeholder="{lang.nhietdo}">
        <input class="input" type="text" id="niemmac" placeholder="{lang.niemmac}">
        <input class="input" type="text" id="khac" placeholder="{lang.khac}">
        <input class="input" type="text" id="dieutri" placeholder="{lang.dieutri}">
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
  var lid = -1;
  var ltid = -1;
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
          console.log(data);
          $("#petname").text(data["petname"])
          $("#customer").text(data["customer"])
          $("#phone").text(data["phone"])
          $("#luubenh").text(data["ngayluubenh"])
          $("#doctor").text(data["doctor"])
          var h_lieutrinh = ""
          if (data["lieutrinh"]) {
            select = -1;
            $("#dslieutrinh").html("")
            data["lieutrinh"].forEach(e => {
              select ++
              var ngay = e["ngay"] * 1000;
              console.log(ngay);
              ltid = e["id"]
              html = "<div click='xemlieutrinh(" + e["id"] + ")'>" + e["ngay"] + "</div>";
              $("#dslieutrinh").html($("#dslieutrinh").html() + html)
            })
            console.log(select, data["lieutrinh"]);
            
            $("#nhietdo").val(data["lieutrinh"][select]["nhietdo"])
            $("#niemmac").val(data["lieutrinh"][select]["niemmac"])
            $("#khac").val(data["lieutrinh"][select]["khac"])
            $("#dieutri").val(data["lieutrinh"][select]["dieutri"])
            $("#xetnghiem").val(data["lieutrinh"][select]["xetnghiem"])
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
        console.log(response)
        switch (response["status"]) {
          case 1:
            // thành công
            var data = response["data"]
            html = "<div click='xemlieutrinh(" + data["id"] + ")'>" + data["ngay"] + "</div>";
            $("#dslieutrinh").html($("#dslieutrinh").html() + html)
          break;
          case 2:
            // đã tồn tại ngày hôm nay
            
          break;
          default:
        }
        if () {
        }
      }
    )
  }

  function xemlieutrinh(id) {
    ltid = id;
  }

  function ketthuc(val) {
    $.post(
      link + "luubenh",
      {action: "trihet", id: lid, val: val},
      (response, status) => {
        // console.log(response);
        response = JSON.parse(response);
        if (response["status"]) {
          $("#vac_info").fadeOut();
          $("#reman").hide();
        }
      }
    )    
  }

  function luulieutrinh(e) {
    e.preventDefault();
    var nhietdo = $("#nhietdo").val();
    var niemmac = $("#niemmac").val();
    var khac = $("#khac").val();
    var xetnghiem = $("#xetnghiem").val();
    var dieutri = $("#dieutri").val();
    
    $.post(
      link + "luubenh",
      {action: "luulieutrinh", id: ltid, nhietdo: nhietdo, niemmac: niemmac, khac: khac, xetnghiem: xetnghiem, dieutri: dieutri},
      (response, status) => {
        response = JSON.parse(response);
        console.log(response);
        // if (response["status"]) {

        // }
      }
    )    
  }
</script>
<!-- END: main -->