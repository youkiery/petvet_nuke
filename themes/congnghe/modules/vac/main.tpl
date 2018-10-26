<!-- BEGIN: main -->
<form onsubmit="return vaccine()" autocomplete="off">
	<table class="tab1 vac">
		<thead>
			<tr>
				<th colspan="4">
					{lang.main_title}
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
					<div id="customer_name_suggest" class="suggest" style="background: white; display:none; position: absolute; overflow-y:scroll; max-height: 300px; width: 90%;"></div>
				</td>
				<td style="position: relative;">
					<input id="customer_phone" style="width: 80%" type="number" name="phone">
					<div id="customer_phone_suggest" class="suggest" style="background: white; display:none; position: absolute; overflow-y:scroll; max-height: 300px; width: 90%;"></div>
					<button onclick="addCustomer()">
						+
					</button>
				</td>
				<td colspan="2">
					<input type="text" name="address">
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
					<select id="pet_info" name="petname"></select>
					<button onclick="addPet()">
						+
					</button>
				</td>
				<td>
					<select id="pet_disease" name="disease">
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
					<textarea id="pet_note" rows="3">{lang.note}</textarea>
				</td>
				<td>
					<input type="submit" value="{lang.submit}">
				</td>
			</tr>
		</tbody>
	</table>
</form>
<style>
	.suggest div:hover {
		background: #afa;
		cursor: pointer;
	}
</style>
<script>
	var link = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=";
	var blur = true;
	var customer_data = [];
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
		var data = ["action=insertvac", "petid=" + pet_info.value, "diseaseid=" + pet_disease.value, "cometime=" + pet_cometime.value, "calltime=" + pet_calltime.value, "note=" + pet_note.value];
		fetch(link + "main", data).then((response) => {
			console.log(response);
		})
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
		fetch(link + "main", data).then(response => {
			response = JSON.parse(response);
			var suggest = document.getElementById(id + "_suggest");
	
			if (response.length) {
				html = "";
				response.forEach (data => {
					var xdata = JSON.stringify(data).replace(/"/g, "\\\'");
					html += '<div class=\"temp\" style=\"padding: 8px 4px;border-bottom: 1px solid black;overflow: overlay;\" onclick=\"getInfo(\'' + xdata + '\')\"><span style=\"float: left;\">' + data.customer + '</span><span style=\"float: right;\">' + data.phone + '</span></div>';
				})
				suggest.innerHTML = html;
				suggest.style.display = "block";
			}
			else {
				suggest.style.display = "note";
			}
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
	function getInfo(data) {
		var data = JSON.parse(data.replace(/'/g, "\""));
		customer_data = data;
		
		customer_name.value = data["customer"];
		customer_phone.value = data["phone"];

		var data = ["action=getpet", "customerid=" + data["id"]];
		fetch(link + "main", data).then(response => {
			var html = "";
			response = JSON.parse(response);
			customer_data["pet"] = response;
			reloadPetOption(response)
		})
		
		suggest_phone.style.display = "none";
		suggest_name.style.display = "none";
	}

	function addCustomer() {
		var phone = customer_phone.value;
		var name = customer_name.value;

		var answer = prompt("Nhập tên khách hàng cho số điện thoại(" + phone + "):", name);
		if(answer) {
			var data = ["action=addcustomer", "customer=" + answer, "phone=" + phone];
			fetch(link + "main", data).then(response => {
				console.log(response);
			})
		}
	}

	function addPet() {
		var customer = document.getElementById("customer_name").value;

		var answer = prompt("Nhập tên thú cưng của khách hàng("+ customer +"):", "");
		if(answer) {
			var data = ["action=addpet", "customerid=" + customer_data["id"], "petname=" + answer];
			fetch(link + "main", data).then(response => {
				var pet_data = JSON.parse(response);

				customer_data["pet"].push({
					id: pet_data.id,
					petname: answer
				});
				reloadPetOption(customer_data["pet"])
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

