<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>
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
      {lang.doctor}: 
      <span id="doctor"></span>
    </p>
  </div>
  <div class="lieutrinh">
    <span id="lieutrinh" style="float: right;"></span>
    <form onsubmit="return themlieutrinh(event)">
      <input type="date" id="ngaylieutrinh" value="{now}" />
      <button>
        {lang.add}
      </button>
    </form>
    <div id="dslieutrinh">
      
    </div>
    <div id="lieutrinh">
      <form onsubmit="return luulieutrinh(event)" id="qllieutrinh">
        <input style="width: 100%" class="input" type="text" id="nhietdo" placeholder="{lang.nhietdo}">
        <input style="width: 100%" class="input" type="text" id="niemmac" placeholder="{lang.niemmac}">
        <input style="width: 100%" class="input" type="text" id="khac" placeholder="{lang.khac}">
        <input style="width: 100%" class="input" type="text" id="dieutri" placeholder="{lang.dieutri}">
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
  <button class="button" style="position: absolute; bottom: 26px; left: 210px;" onclick="tongket()">
    {lang.tongket}
  </button>
</div>

<form method="GET">
	<input type="hidden" name="nv" value="vac">
	<input type="hidden" name="op" value="treat">
	<input class="input" type="text" name="keyword" id="keyword" value="{keyword}" placeholder="{lang.keyword}">
	<input class="input" type="date" name="from" value="{from}">
	<input class="input" type="date" name="to" value="{to}">
	<div class="break"></div>
	<select class="select" name="sort" id="sort">
		<!-- BEGIN: sort -->
		<option value="{sort_value}" {sort_check}>{sort_name}</option>
		<!-- END: sort -->
	</select>
	<select class="select" name="filter" id="time">
		<!-- BEGIN: time -->
		<option value="{time_value}" {time_check}>{time_name}</option>
		<!-- END: time -->
	</select>
	<button class="button">
		{lang.filter}
	</button>
</form>
<img class="anchor" src="/uploads/vac/add.png" alt="{lang.themsieuam}" title="themsieuam" onclick="$('#add').toggle(500)">
<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/contact_add_small.png')" class="vac_icon" onclick="addCustomer()">
	<img src="/themes/congnghe/images/vac/trans.png" title="Thêm khách hàng"> 
</div>
<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/pet_add.png')" class="vac_icon" tooltip="Thêm thú cưng" onclick="addPet()">
	<img src="/themes/congnghe/images/vac/trans.png" title="Thêm thú cưng"> 
</div>
<form style="display: none;" id="add" onsubmit="return themluubenh(event)" autocomplete="off">
	<table class="tab1 vac">
		<thead>
			<tr>
				<th colspan="4">
					{lang.tieude_luubenh}
					<span id="e_notify" style="display: none;"></span>
				</th>
			</tr>
		</thead>
		<tbody>
			<!-- customer title -->
			<tr>
				<td>
					{lang.customer}
				</td>
				<td>
					{lang.phone}
				</td>
				<td colspan="2">
					{lang.address}
				</td>
			</tr>
			<!-- customer input -->
			<tr>
				<td style="position: relative;">
					<input id="customer_name" type="text" name="customer">
					<div id="customer_name_suggest" class="suggest" style="background: white; display:none; position: absolute; overflow-y:scroll; max-height: 300px; width: 110%;"></div>
				</td>
				<td style="position: relative;">
					<input id="customer_phone" style="width: 90%" type="number" name="phone">
					<div id="customer_phone_suggest" class="suggest" style="background: white; display:none; position: absolute; overflow-y:scroll; max-height: 300px; width: 110%;"></div>
				</td>
				<td colspan="2">
					<input id="customer_address" type="text" name="address">
				</td>
			</tr>
			<!-- pet vaccine -->
			<tr>
				<td>
					{lang.petname}
				</td>
				<td colspan="3">
					{lang.ngayluubenh}
				</td>
			</tr>
			<!-- pet input -->
			<tr>
				<td>
					<select id="pet_info" style="text-transform: capitalize;" name="petname"></select>
				</td>
				<td colspan="3">
					<input id="ngayluubenh" type="date" name="ngayluubenh" value="{now}">
				</td>
			</tr>
			<!-- hình ảnh -->
			<tr>
				<td>
					{lang.doctor}
				</td>
				<td colspan="3">
					<select name="doctor" id="doctor2" style="width: 90%;">
						<!-- BEGIN: doctor -->
						<option value="{doctor_value}">{doctor_name}</option>
						<!-- END: doctor -->
					</select>
				</td>
			</tr>
			<!-- note & submit -->
			<tr>
        <td>
          {lang.tinhtrang}
        </td>
				<td colspan="3">
					<select name="tinhtrang" id="tinhtrang2" style="width: 90%;">
						<!-- BEGIN: status -->
						<option value="{status_value}">{status_name}</option>
						<!-- END: status -->
					</select>
        </td>
			</tr>
      <tr>
				<td colspan="4">
					<input type="submit" value="{lang.submit}">
				</td>
      </tr>
		</tbody>
	</table>
</form>

<div id="html_content">
	{content}
</div>
<script>
	var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
	var adlink = "/adminpet/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
	var blur = true;
	var g_customer = -1;
	var customer_data = [];
	var customer_list = [];
	var customer_name = document.getElementById("customer_name");
	var customer_phone = document.getElementById("customer_phone");
	var customer_address = document.getElementById("customer_address");
	var pet_info = document.getElementById("pet_info");
	var pet_note = document.getElementById("pet_note");
	var suggest_name = document.getElementById("customer_name_suggest");
	var suggest_phone = document.getElementById("customer_phone_suggest");

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
		console.log(e);
		
    if (e.keyCode == 27) {
      closeVac()
    }
  })

  function closeVac() {
		console.log(1);
		
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

  $("#html_content tbody tr td[class]").click((e) => {
    lid = e.currentTarget.parentElement.getAttribute("id");
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
          if (data["lieutrinh"]) {
            $("#qllieutrinh input").removeAttr("disabled", "");
            $("#qllieutrinh select").removeAttr("disabled", "");
            select = -1;
            d_lieutrinh = data["lieutrinh"]
            $("#dslieutrinh").html("")
            data["lieutrinh"].forEach(e => {
              select ++
              var ngay = e["ngay"] * 1000;
              g_ltid = e["id"]
              g_id = select
              html = "<span onclick='xemlieutrinh(" + g_ltid + ", " + select +")'>" + e["ngay"] + "</span> ";
              $("#dslieutrinh").html($("#dslieutrinh").html() + html)
            })
            $("#nhietdo").val(data["lieutrinh"][select]["nhietdo"])
            $("#niemmac").val(data["lieutrinh"][select]["niemmac"])
            $("#khac").val(data["lieutrinh"][select]["khac"])
            $("#dieutri").val(data["lieutrinh"][select]["dieutri"])
            $("#xetnghiem").val(data["lieutrinh"][select]["xetnghiem"])
            $("#lieutrinh").text(data["lieutrinh"][select]["ngay"])
            $("#tinhtrang2").val(data["lieutrinh"][select]["tinhtrang"])
          }
          else {
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
    console.log(g_ltid);
    // console.log(d_lieutrinh);
    
    $("#nhietdo").val(d_lieutrinh[id]["nhietdo"])
    $("#niemmac").val(d_lieutrinh[id]["niemmac"])
    $("#khac").val(d_lieutrinh[id]["khac"])
    $("#dieutri").val(d_lieutrinh[id]["dieutri"])
    $("#xetnghiem").val(d_lieutrinh[id]["xetnghiem"])
    $("#lieutrinh").text(d_lieutrinh[id]["ngay"])
    $("#tinhtrang2").val(d_lieutrinh[id]["tinhtrang"])
  }

	function delete_treat(id) {
		var answer = confirm("Xóa bản ghi này?");
		if (answer) {
			$.post(
				link + "luubenh",
				{action: "delete_treat", id: id},
				(response, status) => {
					// console.log(response);
					response = JSON.parse(response);
					console.log(response);
					
					if (response["status"]) {
						window.location.reload()
					}
				}
			)    
		}
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
      {action: "luulieutrinh", id: g_ltid, nhietdo: nhietdo, niemmac: niemmac, khac: khac, xetnghiem: xetnghiem, dieutri: dieutri, tinhtrang: tinhtrang},
      (response, status) => {
        response = JSON.parse(response);
        // console.log(response);
        if (response["status"]) {
          $("#" + lid).css("background", response["data"]["color"])
          $("#" + lid + " .suckhoe").text(response["data"]["tinhtrang"])
          d_lieutrinh[g_id]["nhietdo"] = nhietdo
          d_lieutrinh[g_id]["niemmac"] = niemmac
          d_lieutrinh[g_id]["khac"] = khac
          d_lieutrinh[g_id]["xetnghiem"] = xetnghiem
          d_lieutrinh[g_id]["dieutri"] = dieutri
          d_lieutrinh[g_id]["tinhtrang"] = tinhtrang
        }
      }
    )    
  }


	function xoasieuam(id) {
		var answer = confirm("Xóa bản ghi này?");
		if (answer) {
			$.post(
				"",
				{action: "xoasieuam", id: id},
				(data, status) => {
					data = JSON.parse(data);
					if (data["status"]) {
						$("#html_content").html(data["data"]);
						alert_msg("Đã xóa bản ghi");
					}
				}
			)	
		}
	}

	function themluubenh(event) {
    event.preventDefault();
    // return false;
		msg = "";
		if(!customer_name) {
			msg = "Chưa nhập tên khách hàng!"
		} else if(!customer_phone.value) {
			msg = "Chưa nhập số điện thoại!"
		} else if(!pet_info.value) {
			msg = "Khách hàng chưa có thú cưng!"
		} else {
			$.post(
				link + "themluubenh",
				{"customer": customer_name.value, "phone": customer_phone.value, "address": customer_address.value,idthu: pet_info.value, idbacsi: $("#doctor2").val(), ngayluubenh: $("#ngayluubenh").val(), ghichu: $("#ghichu").val(), tinhtrang: $("#tinhtrang2").val()},
				(data, status) => {
					data = JSON.parse(data);
					if (data["status"] == 1) {
						window.location.reload();
					}
					else {
						msg = data["data"];
						showMsg(msg);
					}
				}
			)
		}
		showMsg(msg);
		return false;
	}

	customer_name.addEventListener("keyup", (e) => {
		showSuggest(e.target.getAttribute("id"), true);
	})

	customer_phone.addEventListener("keyup", (e) => {
		showSuggest(e.target.getAttribute("id"), false);
	})

	suggest_name.addEventListener("mouseenter", (e) => {
		blur = false;
	})
	suggest_name.addEventListener("mouseleave", (e) => {
		blur = true;
	})
	customer_name.addEventListener("focus", (e) => {
		suggest_name.style.display = "block";
	})
	customer_name.addEventListener("blur", (e) => {
		if(blur) {
			suggest_name.style.display = "none";
		}
	})
	suggest_phone.addEventListener("mouseenter", (e) => {
		blur = false;
	})
	suggest_phone.addEventListener("mouseleave", (e) => {
		blur = true;
	})
	customer_phone.addEventListener("focus", (e) => {
		suggest_phone.style.display = "block";
	})
	customer_phone.addEventListener("blur", (e) => {
		if(blur) {
			suggest_phone.style.display = "none";
		}
	})

</script>
<!-- END: main -->
