<!-- BEGIN: main -->
<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<a href="/index.php?nv=vac&op=list">
	{lang.main_title}
</a>
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
<style>
	.vac_icon:hover {
		background-position-x: 32px;
	}
	.suggest div:hover {
		background: #afa;
		cursor: pointer;
	}
</style>
<script>
	var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=main&act=post";
	var blur = true;
	var customer_data = [];
	var customer_list = [];
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
			var data = ["action=insertvac", "customer=" + customer_name.value, "phone=" + customer_phone.value, "petid=" + pet_info.value, "diseaseid=" + pet_disease.value, "cometime=" + pet_cometime.value, "calltime=" + pet_calltime.value, "note=" + pet_note.value];
			fetch(link, data).then((response) => {
				response = JSON.parse(response);
				switch (response["status"]) {
					case 2:
						msg = "Đã lưu bản ghi tiêm chủng";

						customer_name.value = ""
						customer_phone.value = ""
						pet_info.innerHTML = ""
						pet_note.value = "Ghi chú"
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
	function fetch(url, data) {
		return new Promise(resolve => {
			var param = data.join("&");
			
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var response = this.responseText;
					resolve(response);
				}
			};
			xhttp.open("POST", url, true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(param);			
		})	
	}
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
							msg = "Đã thêm khách hàng: " + answer + "; Số điện thoại: " + phone;
							customer_data = {
								id: response["data"][0]["id"],
								customer: answer,
								phone: phone,
								pet: []
							}
							customer_name.value = answer;
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
		var customer = document.getElementById("customer_name").value;

		var answer = prompt("Nhập tên thú cưng của khách hàng("+ customer +"):", "");
		var msg = "";
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
						msg = "Đã thêm thú cưng("+answer+")";
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

	function reloadPetOption(petlist) {
		html = "";
		petlist.forEach((pet_data, petid) => {
			html += "<option value='"+ pet_data["id"] +"'>" + pet_data["petname"] + "</option>";
		})
		document.getElementById("pet_info").innerHTML = html;
	}

</script>
<!-- END: main -->

