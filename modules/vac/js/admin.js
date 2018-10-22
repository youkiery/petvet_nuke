
function vac_disease_add(e) {
	var index = Number(e.getAttribute("id"))  + 1;
	e.setAttribute("id", index);
	var form = document.getElementById("vac");
	var div = document.createElement("div");
	div.setAttribute("id", "vac_remove_" + index);
	var input = document.createElement("input");
	input.setAttribute("name", "d_name[" + index + "]");
	input.setAttribute("type", "text");
	input.setAttribute("class", "vac_val");
	input.setAttribute("value", "");
	var button = document.createElement("input");
	button.setAttribute("type", "button");
	button.setAttribute("value", "Xóa");
	button.setAttribute("onclick", "vac_disease_remove(" + index + ")");
	div.appendChild(input);
	div.appendChild(button);
	form.appendChild(div);
}

function vac_disease_remove(index) {
	var e = document.getElementById("vac_remove_" + index);
	e.remove();
}

function vac_submit_disease() {
	var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=disease";
	var data = document.getElementsByClassName("vac_val");
	var post_data = [];
	var length = data.length;
	for (let index = 0; index < length; index++) {
		post_data.push(data[index].getAttribute("name") + "=" + data[index].value);
	};
	fetch(url, post_data).then(response => {
		var msg = "";
		if(response == 1) {
			msg = "Lưu thành công";
		}
		else {
			msg = "Chưa cập nhật";
		}
		showMsg(msg);
	})

	return false;
}
function vac_add_customer() {
	var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
	var data = document.getElementsByClassName("vac_val");
	var post_data = ["action=add"];
	var length = data.length;
	for (let index = 0; index < length; index++) {
		post_data.push(data[index].getAttribute("name") + "=" + data[index].value);
	};
	fetch(url, post_data).then(response => {
		// clear form
		// add to panel
		
		var msg = "Lưu thành công";
		if(response) {
			var data = JSON.parse(response);
			var tr = document.createElement("tr");
			var td_name = document.createElement("td");
			var td_phone = document.createElement("td");
			var td_note = document.createElement("td");
			var td_button = document.createElement("td");
			var button_remove = document.createElement("button");
			var button_update = document.createElement("button");
			td_name.innerText = data["name"];
			td_phone.innerText = data["phone"];
			td_note.innerText = data["note"];
			td_name.setAttribute("id", "customer_name_" + data["id"] + ")");
			td_phone.setAttribute("id", "customer_phone_" + data["id"] + ")");
			td_note.setAttribute("id", "customer_note_" + data["id"] + ")");
			button_remove.setAttribute("onclick", "vac_remove_customer(" + data["id"] + ")");
			button_remove.innerText = "Xóa";
			button_update.setAttribute("onclick", "vac_get_update_customer(" + data["id"] + ", " + data["name"] + ", " + data["phone"] + ", " + data["note"] + ")");
			button_update.innerText = "Cập nhật";
			td_button.appendChild(button_remove);
			td_button.appendChild(button_update);
			tr.appendChild(td_name);
			tr.appendChild(td_phone);
			tr.appendChild(td_note);
			tr.appendChild(td_button);
			document.getElementById("vac_body").appendChild(tr);
		}
		else {
			var msg = "Chưa lưu được";
		}
		showMsg(msg);
	})
	
	return false;
}

function vac_remove_customer(id) {
	if(confirm("Bạn có muốn xóa khách hàng này không?")) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
		post_data = ["action=remove", "id=" + id];
		fetch(url, post_data).then(response => {
			var msg = "";
			if(response) {
				document.getElementById("customer_" + id).remove();
				msg = "Xóa thành công";
			}
			else {
				msg = "Chưa xoá được";
			}
			showMsg(msg);
		})			
	}
}

function vac_get_update_customer(id, name, phone, note) {
	document.getElementById("customer").value = name;
	document.getElementById("phone").value = phone;
	document.getElementById("note").value = note;
	document.getElementById("update").setAttribute("onclick", "vac_update_customer("+ id +")");
}

function vac_update_customer(id) {
	if(id) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
		var data = document.getElementsByClassName("vac_val");
		var post_data = ["action=update", "id=" + id];
		var length = data.length;
		for (let index = 0; index < length; index++) {
			post_data.push(data[index].getAttribute("name") + "=" + data[index].value);
		};
		fetch(url, post_data).then(response => {	
			if(response) {
				var data = JSON.parse(response);
				document.getElementById("customer_name_" + data["id"]).value = name;
				document.getElementById("customer_phone_" + data["id"]).value = phone;
				document.getElementById("customer_note_" + data["id"]).value = note;			
				msg = "Cập nhật thành công";
			}
			else {
				msg = "Chưa cập nhật được";
			}
			showMsg(msg);
		})
	}
}

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

function showMsg(msg) {
	var e_notify = document.getElementById("vac_notify");
	e_notify.innerText = msg;
	e_notify.style.display = "block";
	e_notify.style.opacity = 1;
	var timer = 0;
	setTimeout(() => {
		var interval = setInterval(() => {
			if(timer == 5) {
				clearInterval(interval);
				e_notify.style.display = "none";
				e_notify.style.opacity = 0;
			}
			timer ++;
			e_notify.style.opacity *= 0.75;
		}, 100)
	}, 1000)
}
