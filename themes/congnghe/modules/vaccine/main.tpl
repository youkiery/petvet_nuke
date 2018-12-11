<!-- BEGIN: overtime -->
 <p>
   Đã hết thời gian làm việc, xin hãy quay trở lại vào ngày mai!  
 </p>
 
<!-- END: overtime -->
<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>
<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<div style="float: right;">
	<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/contact_add_small.png')" class="vac_icon" onclick="addCustomer()">
		<img src="/themes/congnghe/images/vac/trans.png" title="Thêm khách hàng"> 
	</div>
	<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/pet_add.png')" class="vac_icon" tooltip="Thêm thú cưng" onclick="addPet()">
		<img src="/themes/congnghe/images/vac/trans.png" title="Thêm thú cưng"> 
	</div>
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
					{lang.cometime}
				</td>
				<td>
					{lang.calltime}
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
					{lang.doctor2}
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
<script>
	var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=main&act=post";
	var blur = true;
	var customer_data = [];
  var customer_list = [];
  var g_index = -1;
	var customer_name = document.getElementById("customer_name");
	var customer_phone = document.getElementById("customer_phone");
	var customer_address = document.getElementById("customer_address");
	var pet_info = document.getElementById("pet_info");
	var pet_disease = document.getElementById("pet_disease");
	var pet_cometime = document.getElementById("pet_cometime");
	var pet_calltime = document.getElementById("pet_calltime");
	var pet_note = document.getElementById("pet_note");
	var suggest_name = document.getElementById("customer_name_suggest");
	var suggest_phone = document.getElementById("customer_phone_suggest");

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
						alert_msg("Đã lưu vào lịch báo tiêm phòng");
            customer_list[g_index]["customer"] = customer_name.value
            customer_list[g_index]["address"] = customer_address.value
            g_index = -1;
						customer_name.value = ""
						customer_phone.value = ""
            customer_address.value = ""
						pet_info.innerHTML = ""
            pet_note.value = "Ghi chú"
            console.log(customer_list, g_index);
            
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

