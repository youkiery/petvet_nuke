<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>
<div style="float: right;">
	<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/contact_add_small.png')" class="vac_icon" onclick="addCustomer()">
		<img src="/themes/congnghe/images/vac/trans.png" title="Thêm khách hàng"> 
	</div>
	<div style="width: 32px; height: 32px; cursor: pointer; display: inline-block; background-image: url('/themes/congnghe/images/vac/pet_add.png')" class="vac_icon" tooltip="Thêm thú cưng" onclick="addPet()">
		<img src="/themes/congnghe/images/vac/trans.png" title="Thêm thú cưng"> 
	</div>
</div>
<form onsubmit="return themluubenh(event)" autocomplete="off">
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
					<select name="doctor" id="doctor" style="width: 90%;">
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
					<select name="tinhtrang" id="tinhtrang" style="width: 90%;">
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
<script>
	var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
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

	function themluubenh(event) {
		event.preventDefault();
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
				{idthu: pet_info.value, idbacsi: $("#doctor").val(), ngayluubenh: $("#ngayluubenh").val(), ghichu: $("#ghichu").val(), tinhtrang: $("#tinhtrang").val()},
				(data, status) => {
					data = JSON.parse(data);
					if (data["status"] == 1) {
						alert_msg(data["data"]);
						customer_name.value = "";
						customer_phone.value = "";
						customer_address.value = "";
						pet_info.innerHTML = "";
						pet_note.innerText = "Ghi chú";
						g_customer = -1;
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
