<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<form id="add" onsubmit="return themsieuam(event)" autocomplete="off">
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
					<input class="input" id="customer_name" type="text" name="customer">
					<div id="customer_name_suggest" class="suggest" style="background: white; display:none; position: absolute; overflow-y:scroll; max-height: 300px; width: 110%;"></div>
				</td>
				<td style="position: relative;">
					<input class="input" id="customer_phone" style="width: 90%" type="number" name="phone">
					<div id="customer_phone_suggest" class="suggest" style="background: white; display:none; position: absolute; overflow-y:scroll; max-height: 300px; width: 110%;"></div>
				</td>
				<td colspan="2">
					<input class="input" id="customer_address" type="text" name="address">
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
			</tr>
			<!-- pet input -->
			<tr>
				<td>
					<select class="input" id="pet_info" style="text-transform: capitalize;" name="petname"></select>
				</td>
				<td>
					<input class="input" id="ngaysieuam" type="date" name="ngaysieuam" value="{now}">
				</td>
				<td>
					<input class="input" id="calltime" type="date" name="calltime" value="{dusinh}">
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
					<input class="input inmax" type="text" name="hinhanh" id="hinhanh" disabled>
					<div class="icon upload" type="button" value="{lang.chonanh}" name="selectimg" ></div>
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
					<textarea id="ghichu" rows="3" style="width: 98%;"></textarea>
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

	function xoasieuam(id) {
		var answer = confirm("Xóa bản ghi này?");
		if (answer) {
			$.post(
				"",
				{action: "xoasieuam", id: id},
				(data, status) => {
					data = JSON.parse(data);
					if (data["status"]) {
						window.location.reload()
					}
				}
			)	
		}
	}

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
				{petid: pet_info.value, doctorid: $("#doctor").val(), cometime: $("#ngaysieuam").val(), calltime: $("#calltime").val(), image: $("#hinhanh").val(), note: $("#note").val()},
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
