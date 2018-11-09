<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<form method="GET">
	<input type="hidden" name="nv" value="vac">
	<input type="hidden" name="op" value="sieuam">
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
<form style="display: none;" id="add" onsubmit="return themsieuam(event)" autocomplete="off">
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
				<td>
					{lang.ngaybao}
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
					<input class="input" id="ngaydusinh" type="date" name="ngaysieuam" value="{dusinh}">
				</td>
				<td>
					<input class="input" id="ngaythongbao" type="date" name="ngaythongbao" value="{thongbao}">
				</td>
			</tr>
			<!-- hình ảnh -->
			<tr>
				<td>
					{lang.hinhanh}
				</td>
				<td colspan="3">
					<input class="input inmax" type="text" name="hinhanh" id="hinhanh">
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
					<textarea id="pet_note" rows="3" style="width: 98%;">{lang.note}</textarea>
				</td>
				<td>
					<input type="submit" value="{lang.submit}">
				</td>
			</tr>
		</tbody>
	</table>
</form>

<div>
	{content}
</div>
<div>
	{nav_link}
</div>
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

	function themsieuam(event) {
		event.preventDefault();
		msg = "";
		if(!customer_name) {
			msg = "Chưa nhập tên khách hàng!"
		} else if(!customer_phone.value) {
			msg = "Chưa nhập số điện thoại!"
		} else if(!pet_info.value) {
			msg = "Khách hàng chưa có thú cưng!"
		} else if (!$("#hinhanh").val().length) {
			msg = "Chưa có hình ảnh!"
		} else {
			$.post(
				link + "themsieuam",
				{idthu: pet_info.value, /*idbacsi: $doctor.value,*/ ngaysieuam: $("#ngaysieuam").val(), ngaydusinh: $("#ngaydusinh").val(), ngaythongbao: $("#ngaythongbao").val(), hinhanh: $("#hinhanh").val(), ghichu: $("#ghichu").val()},
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

	function showSuggest (id, type) {
		var name = "", phone = "";
		if(type) {
			name = vi(document.getElementById("customer_name").value);
		} else {
			phone = String(document.getElementById("customer_phone").value);
		}
		var data = ["action=getcustomer", "customer=" + name, "phone=" + phone];
		fetch(link, data).then(response => {
			response = JSON.parse(response);
			var suggest = document.getElementById(id + "_suggest");
	
			customer_list = response["data"]
			html = "";
			if (response["data"].length) {
				response["data"].forEach ((data, index) => {
					html += '<div class=\"temp\" style=\"padding: 8px 4px;border-bottom: 1px solid black;overflow: overlay; text-transform: capitalize;\" onclick=\"getInfo(\'' + index + '\')\"><span style=\"float: left;\">' + data.customer + '</span><span style=\"float: right;\">' + data.phone + '</span></div>';
				})
				suggest.style.display = "block";
			}
			else {
				suggest.style.display = "note";
			}
			suggest.innerHTML = html;
		})
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
	function vi(str) { 
    str= str.toLowerCase();
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
    str= str.replace(/đ/g,"d"); 

    return str; 
	}
	function getInfo(index) {
		customer_data = customer_list[index];		
		customer_name.value = customer_data["customer"];
		customer_phone.value = customer_data["phone"];
		customer_address.value = customer_data["address"];
		g_customer = customer_data["id"]
		var data = ["action=getpet", "customerid=" + customer_data["id"]];
		fetch(link, data).then(response => {
			var html = "";
			response = JSON.parse(response);
			customer_data["pet"] = response["data"];
			reloadPetOption(customer_data["pet"])
		})
		
		suggest_phone.style.display = "none";
		suggest_name.style.display = "none";
	}

	function addCustomer() {
		var phone = customer_phone.value;
		var name = customer_name.value;
		var address = customer_address.value;
		msg = "";
		if(phone.length) {
			var answer = prompt("Nhập tên khách hàng cho số điện thoại(" + phone + "):", name);
			if(answer) {
				var data = ["action=addcustomer", "customer=" + answer, "phone=" + phone, "address=" + address];
				fetch(link, data).then(response => {
					response = JSON.parse(response);
					switch (response["status"]) {
						case 1:
							msg = "Số điện thoại đã được sử dụng: " + phone;							
							break;
						case 3:
							msg = "Tên khách hàng đã được sử dụng: " + phone;							
							break;
						case 2:
							alert_msg("Đã thêm khách hàng: " + answer + "; Số điện thoại: " + phone);
							customer_data = {
								id: response["data"][0]["id"],
								customer: answer,
								phone: phone,
								pet: []
							}
							customer_name.value = answer;
							g_customer = response["data"][0]["id"];
							reloadPetOption(customer_data["pet"])
							break;
						default:
							msg = "Không để trống tên và số điện thoại!";
					}
					showMsg(msg);
				})
			}
		}
		else {
			msg = "Không để trống số điện thoại!";
		}
		showMsg(msg);
	}

	function addPet() {
		var msg = "";
		if (g_customer === -1) {
			msg = "Chưa chọn khách hàng";
		} else {
			var customer = document.getElementById("customer_name").value;

			var answer = prompt("Nhập tên thú cưng của khách hàng("+ customer +"):", "");
			if(answer) {
				var data = ["action=addpet", "customerid=" + customer_data["id"], "petname=" + answer];
				fetch(link, data).then(response => {
					var response = JSON.parse(response);

					switch (response["status"]) {
						case 1:
							msg = "Khách hàng hoặc tên thú cưng không tồn tại";						
							break;
						case 2:
							customer_data["pet"].push({
								id: response["data"][0].id,
								petname: answer
							});
							reloadPetOption(customer_data["pet"])
							alert_msg("Đã thêm thú cưng(" + answer + ")");
							break;
						case 3:
							msg = "Tên thú cưng không hợp lệ";
							break;
						case 4:
							msg = "Tên khách hàng không hợp lệ";
							break;
						default:
							msg = "Lỗi mạng!";
					}
					showMsg(msg);
				})
			}
		}
		showMsg(msg);
	}

	function reloadPetOption(petlist) {
		html = "";
		petlist.forEach((pet_data, petid) => {
			html += "<option value='"+ pet_data["id"] +"'>" + pet_data["petname"] + "</option>";
		})
		document.getElementById("pet_info").innerHTML = html;
	}

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
