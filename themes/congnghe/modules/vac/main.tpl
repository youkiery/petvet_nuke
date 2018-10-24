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
					<select id="pet_name" name="petname"></select>
					<button onclick="addPet()">
						+
					</button>
				</td>
				<td>
					<select name="disease">
						<!-- BEGIN: option -->
						<option value="{disease_id}">
							{disease_name}
						</option>
						<!-- END: option -->
					</select>
				</td>
				<td>
					<input type="date" name="cometime" value="{now}">
				</td>
				<td>
					<input type="date" name="calltime" value="{calltime}">
				</td>
			</tr>
			<!-- note & submit -->
			<tr>
				<td colspan="3">
					<textarea rows="3">{lang.note}</textarea>
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
	function vaccine() {
		return false;
	}
	var customer_data = [{
		name: "anh bay",
		phone: "01234567890",
		pet: ["cún a1", "cún a2", "cún a3"]
	},
	{
		name: "chi hong",
		phone: "097784755",
		pet: ["cún b1", "cún b2", "cún b3", "cún b3"]
	},
	{
		name: "chu tu",
		phone: "0979124648",
		pet: ["cún c1"]
	},
	{
		name: "bac quang",
		phone: "033879554",
		pet: ["cún d1", "cún d2", "cún d3"]
	},
	{
		name: "ong sau",
		phone: "038453255",
		pet: ["cún f1", "cún f2"]
	},
	{
		name: "chi tuyết",
		phone: "036487915",
	}];
	customer_data.forEach(data => {
		data["name"] = vi(data["name"])
	})
	var blur = true;
	var suggest_name = document.getElementById("customer_name_suggest");
	var suggest_phone = document.getElementById("customer_phone_suggest");


	document.getElementById("customer_name").addEventListener("keydown", (e) => {
		var name = vi(e.target.value);
		var search_result = customer_data.filter(data => {
			return data.name.search(name) >= 0
		})
		if(search_result.length) {
			html = "";
			search_result.forEach(data => {
				var xdata = JSON.stringify(data).replace(/"/g, "\\\'");
				html += '<div class=\"temp\" style=\"padding: 8px 4px;border-bottom: 1px solid black;overflow: overlay;\" onclick=\"getInfo(\'' + xdata + '\')\"><span style=\"float: left;\">' + data.name + '</span><span style=\"float: right;\">' + data.phone + '</span></div>';
			})
			suggest_name.style.display = "block";
			suggest_name.innerHTML = html
		}
		else {
			suggest_name.style.display = "none";
		}
		console.log(search_result);
		
		// fetch(link + "vaccine", ["name="])
	})

	document.getElementById("customer_phone").addEventListener("keydown", (e) => {
		var phone = String(e.target.value);
		var search_result = customer_data.filter(data => {
			return data.phone.search(phone) >= 0
		})
		if(search_result.length) {
			suggest_phone.style.display = "block";
			html = "";
			search_result.forEach(data => {
				var xdata = JSON.stringify(data).replace(/"/g, "\\\'");
				html += '<div class=\"temp\" style=\"padding: 8px 4px;border-bottom: 1px solid black;overflow: overlay;\" onclick=\"getInfo(\'' + xdata + '\')\"><span style=\"float: left;\">' + data.name + '</span><span style=\"float: right;\">' + data.phone + '</span></div>';
			})
			suggest_phone.innerHTML = html
		}
		else {
			suggest_phone.style.display = "none";
		}
		console.log(search_result);
		
		// fetch(link + "vaccine", ["name="])
	})

	document.getElementById("customer_name_suggest").addEventListener("mouseenter", (e) => {
		blur = false;
	})
	document.getElementById("customer_name_suggest").addEventListener("mouseleave", (e) => {
		blur = true;
	})
	document.getElementById("customer_name").addEventListener("focus", (e) => {
		suggest_name.style.display = "block";
	})
	document.getElementById("customer_name").addEventListener("blur", (e) => {
		if(blur) {
			suggest_name.style.display = "none";
		}
	})
	document.getElementById("customer_phone_suggest").addEventListener("mouseenter", (e) => {
		blur = false;
	})
	document.getElementById("customer_phone_suggest").addEventListener("mouseleave", (e) => {
		blur = true;
	})
	document.getElementById("customer_phone").addEventListener("focus", (e) => {
		suggest_phone.style.display = "block";
	})
	document.getElementById("customer_phone").addEventListener("blur", (e) => {
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
		
		document.getElementById("customer_name").value = data["name"];
		document.getElementById("customer_phone").value = data["phone"];
		var html = "";
		console.log(data);
		
		data["pet"].forEach((petname, index) => {
			html += "<option value='"+index+"'>" + petname + "</option>";
		})
		document.getElementById("pet_name").innerHTML = html;
		suggest_phone.style.display = "none";
		suggest_name.style.display = "none";
	}

	function addCustomer() {
		var phone = document.getElementById("customer_phone").value;
		var name = document.getElementById("customer_name").value;

		var answer = prompt("Nhập tên khách hàng cho số điện thoại(" + phone + "):", name);
		if(answer) {
			customer_data.push({
				name: answer,
				phone: phone,
				pet: []
			})
		}
	}

	function addPet() {
		var customer = document.getElementById("customer_name").value;

		var answer = prompt("Nhập tên thú cưng của khách hàng("+ customer +"):", "");
		if(answer) {
			var x = customer_data.filter(data => {
				return data["name"] == customer
			})
			
			x[0]["pet"].push(answer)
			x[0]["pet"].forEach((petname, index) => {
				html += "<option value='"+index+"'>" + petname + "</option>";
			})
			document.getElementById("pet_name").innerHTML = html;
		}
	}

</script>
<!-- END: main -->

