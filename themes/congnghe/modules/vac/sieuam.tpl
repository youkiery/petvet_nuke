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
<form onsubmit="return themsieuam(event)" autocomplete="off">
	<table class="tab1 vac">
		<thead>
			<tr>
				<th colspan="4">
					{lang.tieude_sieuam}
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
				<td>
					{lang.ngaysieuam}
				</td>
				<td>
					{lang.ngaydusinh}
				</td>
				<td>
					{lang.ngaybao}
				</td>
			</tr>
			<!-- pet input -->
			<tr>
				<td>
					<select id="pet_info" style="text-transform: capitalize;" name="petname"></select>
				</td>
				<td>
					<input id="ngaysieuam" type="date" name="ngaysieuam" value="{now}">
				</td>
				<td>
					<input id="ngaydusinh" type="date" name="ngaysieuam" value="{dusinh}">
				</td>
				<td>
					<input id="ngaythongbao" type="date" name="ngaythongbao" value="{thongbao}">
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
			<tr>
				<td>
					{lang.hinhanh}
				</td>
				<td colspan="3">
					<input class="input" type="text" name="hinhanh" id="hinhanh" disabled>
					<div class="icon upload" type="button" value="{lang.chonanh}" name="selectimg"></div>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<img class="thump" id="thump">
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
	var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
	var blur = true;
	var g_customer = -1;
  var g_index = -1
	var customer_data = [];
	var customer_list = [];
	var customer_name = document.getElementById("customer_name");
	var customer_phone = document.getElementById("customer_phone");
	var customer_address = document.getElementById("customer_address");
	var pet_info = document.getElementById("pet_info");
	var pet_note = document.getElementById("pet_note");
	var suggest_name = document.getElementById("customer_name_suggest");
	var suggest_phone = document.getElementById("customer_phone_suggest");

	function themsieuam(event) {
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
				link + "themsieuam",
				{customer: customer_name.value, phone: customer_phone.value, address: customer_address.value, idthu: pet_info.value, idbacsi: $("#doctor").val(), ngaysieuam: $("#ngaysieuam").val(), ngaydusinh: $("#ngaydusinh").val(), ngaythongbao: $("#ngaythongbao").val(), hinhanh: $("#hinhanh").val(), ghichu: $("#ghichu").val()},
				(data, status) => {
					data = JSON.parse(data);
					if (data["status"] == 1) {
            alert_msg(data["data"]);
            console.log(g_index);
            
            customer_list[g_index]["customer"] = customer_name.value
            customer_list[g_index]["address"] = customer_address.value
            g_index = -1;
						customer_name.value = "";
						customer_phone.value = "";
						customer_address.value = "";
						pet_info.innerHTML = "";
						pet_note.innerText = "Ghi chú";
            g_customer = -1;
						$("#hinhanh").val("");
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
