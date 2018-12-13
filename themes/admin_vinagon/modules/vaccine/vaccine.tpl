<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>
<div id="reman"></div>
<div id="vac_info" style="display:none;">
    <div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/contact_add_small.png')" class="vac_icon" onclick="addCustomer()">
    	<img src="/themes/congnghe/images/vac/trans.png" title="Thêm khách hàng"> 
    </div>
    <div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/pet_add.png')" class="vac_icon" tooltip="Thêm thú cưng" onclick="addPet()">
    	<img src="/themes/congnghe/images/vac/trans.png" title="Thêm thú cưng"> 
    </div>
	<form onsubmit="return vaccine()" autocomplete="off">
		<table class="tab1 vac">
			<thead>
				<tr>
					<th colspan="4">
						{lang.disease_title}
						<span id="e_notify" style="color: red; display: none;"></span>
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
					<td>
						{lang.disease}
					</td>
					<td>
						{lang.vaccome}
					</td>
					<td>
						{lang.vaccall}
					</td>
				</tr>
				<!-- pet input -->
				<tr>
					<td>
						<select id="pet_info" style="text-transform: capitalize;" name="petname"></select>
					</td>
					<td>
						<select id="pet_disease" class="vac_select_max" style="text-transform: capitalize;" name="disease">
							<!-- BEGIN: option -->
							<option value="{disease_id}">
								{disease_name}
							</option>
							<!-- END: option -->
						</select>
					</td>
					<td>
						<input id="pet_cometime" type="date" name="cometime" value="{now}">
					</td>
					<td>
						<input id="pet_calltime" type="date" name="calltime" value="{calltime}">
					</td>
				</tr>
				<tr>
					<td>
						{lang.vacdoctor}
					</td>
					<td colspan="3">
						<select id="doctor">
							<!-- BEGIN: doctor -->
							<option value="{doctorid}">{doctorname}</option>
							<!-- END: doctor -->
						</select>
					</td>
				</tr>
				<!-- note & submit -->
				<tr>
					<td colspan="3">
						<textarea id="pet_note" rows="3" style="width: 98%;">{lang.note}</textarea>
					</td>
					<td>
						<input type="submit" value="{lang.submit}">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

<div id="vac_info2" style="display:none;">
		<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vaccine/contact_edit.png')" class="vac_icon" onclick="update_customer(g_customerid)">
			<img src="/themes/congnghe/images/vac/trans.png" title="Sửa khách hàng"> 
		</div>
		<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vaccine/pet_edit.png')" class="vac_icon" tooltip="Sửa thú cưng" onclick="update_pet(g_petid, g_pet)">
			<img src="/themes/congnghe/images/vac/trans.png" title="Thêm thú cưng"> 
		</div>
		<form onsubmit="return editvac()" autocomplete="off">
		<table class="tab1 vac">
			<thead>
				<tr>
					<th colspan="4">
						{lang.disease_title}
						<span id="e_notify" style="color: red; display: none;"></span>
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- pet vaccine -->
				<tr>
					<td>
						{lang.disease}
					</td>
					<td>
						{lang.vaccome}
					</td>
					<td>
						{lang.vaccall}
					</td>
				</tr>
				<!-- pet input -->
				<tr>
					<td>
						<select id="disease2" class="vac_select_max" style="text-transform: capitalize;" name="disease">
							<!-- BEGIN: option2 -->
							<option value="{disease_id}">
								{disease_name}
							</option>
							<!-- END: option2 -->
						</select>
					</td>
					<td>
						<input id="cometime2" type="date" name="cometime" value="{now}">
					</td>
					<td>
						<input id="calltime2" type="date" name="calltime" value="{calltime}">
					</td>
				</tr>
				<tr>
					<td>
						{lang.doctor2}
					</td>
					<td colspan="2">
						<select id="doctor2">
							<!-- BEGIN: doctor2 -->
							<option value="{doctorid}">{doctorname}</option>
							<!-- END: doctor2 -->
						</select>
					</td>
				</tr>
				<!-- note & submit -->
				<tr>
					<td colspan="2">
						<textarea id="note2" rows="3" style="width: 98%;"></textarea>
					</td>
					<td>
						<input type="submit" value="{lang.submit}">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

<form method="GET">
	<input type="hidden" name="nv" value="{nv}">
	<input type="hidden" name="op" value="{op}">
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
<img class="anchor" src="/uploads/vac/add.png" alt="{lang.themsieuam}" title="themsieuam" onclick="open_vac()">

<div id="html_content">
	{content}
</div>
<script>
	var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
	var adlink = "/adminpet/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
	var blur = true;
	var g_customerid = -1
	var g_petid = -1
	var g_pet = ""

	var g_customer = -1;
	var g_id = -1;
	var customer_data = [];
	var customer_list = [];
	var customer_name = document.getElementById("customer_name");
	var customer_phone = document.getElementById("customer_phone");
	var customer_address = document.getElementById("customer_address");
	var pet_info = document.getElementById("pet_info");
	var pet_note = document.getElementById("pet_note");
	var suggest_name = document.getElementById("customer_name_suggest");
	var suggest_phone = document.getElementById("customer_phone_suggest");

	function open_vac() {
		$('#vac_info').fadeIn();
		$('#reman').show();
	}

	function open_edit(event, id) {
		g_id = id

		$.post(
			adlink + "vaccine",
			{action: "getvac", id: id},
			(response, status) => {
				data = JSON.parse(response)
				if (data) {
					g_id = id
					g_pet = data.petname
					g_customerid = data.customerid
					$("#doctor2").val(data.doctorid);
					$("#disease2").val(data.diseaseid);
					$("#cometime2").val(data.cometime);
					$("#calltime2").val(data.calltime);
					$("#note2").val(data.note);
				}
			})
		$('#vac_info2').fadeIn();
		$('#reman').show();
	}

  $("#reman").click(() => {
    closeVac()
  })

  $("body").keydown((e) => {
    if (e.keyCode == 27) {
      closeVac()
    }
  })

  function closeVac() {
      $("#vac_info").fadeOut();
      $("#vac_info2").fadeOut();
      $("#reman").hide();
  }

	function xoasieuam(id) {
		var answer = confirm("Xóa bản ghi này?");
		if (answer) {
			$.post(
				"",
				{action: "remove_vaccine", id: id},
				(data, status) => {
					if (data) {
						window.location.reload()
					}
				}
			)	
		}
	}

	function update(id) {

	}

	function vaccine() {
		msg = "";
		if(!customer_name) {
			msg = "Chưa nhập tên khách hàng!"
		} else if(!customer_phone.value) {
			msg = "Chưa nhập số điện thoại!"
		} else if(!pet_info.value) {
			msg = "Khách hàng chưa có thú cưng!"
		} else if (!pet_disease.value) {
			msg = "Chưa có loại tiêm phòng!";
		} else if (!pet_cometime.value) {
			msg = "Chưa có thời gian tiêm phòng";
		} else if (!pet_calltime.value) {
			msg = "Chưa có ngày tái chủng!";
		}
		else {
			var data = ["action=insertvac", "customer=" + customer_name.value, "phone=" + customer_phone.value, "address=" + customer_address.value, "petid=" + pet_info.value, "diseaseid=" + pet_disease.value, "cometime=" + pet_cometime.value, "calltime=" + pet_calltime.value, "note=" + pet_note.value, "doctorid=" + document.getElementById("doctor").value];
			fetch(link, data).then((response) => {
				response = JSON.parse(response);
				switch (response["status"]) {
					case 2:
						window.location.reload()
						break;
					case 3:
						msg = "Thú cưng không tồn tại!";
						break;
					case 4:
						msg = "Khách hàng không tồn tại!";
						break;
					case 5:
						msg = "lỗi không xác định!";
						break;
					default:
						msg = "lỗi không xác định!"
				}
				showMsg(msg);
			})
		}
		showMsg(msg);
		return false;
	}

	function editvac() {
		msg = "";
		if (!$("#disease2").val()) {
			msg = "Chưa có loại tiêm phòng!";
		} else if (!$("#cometime2").val()) {
			msg = "Chưa có thời gian tiêm phòng";
		} else if (!$("#calltime2").val()) {
			msg = "Chưa có ngày tái chủng!";
		}
		else {
			$.post(
				adlink + "vaccine",
				{action: "editvac", id: g_id, diseaseid: $("#disease2").val(), cometime: $("#cometime2").val(), calltime: $("#calltime2").val(), note: $("#note2").val(), doctorid: $("#doctor2").val()},
				(response, status) => {
					data = JSON.parse(response)
					if (data) {
						window.location.reload()
					}
				}
			)
		}
		showMsg(msg);
		return false;
	}

	suggest_init()


	$("div[name=selectimg]").click(function(){
		var area = "hinhanh";
		var path= "{NV_UPLOADS_DIR}/{module_name}";	
		var currentpath= "{CURRENT}";						
		var type= "image";
		nv_open_browse_file("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
</script>
<!-- END: main -->
