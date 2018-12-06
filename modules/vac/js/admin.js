
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
	input.setAttribute("style", 'style="text-transform:capitalize;"');
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
			var a_name = document.createElement("a");
			var td_phone = document.createElement("td");
			var td_address = document.createElement("td");
			var td_button = document.createElement("td");
			var button_remove = document.createElement("button");
			var button_update = document.createElement("button");
			a_name.innerText = data["name"];
			a_name.setAttribute("href", "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer&customerid="+data["id"]);
			a_name.setAttribute("id", "customer_name_" + data["id"]);
			td_name.appendChild(a_name);
			td_phone.innerText = data["phone"];
			td_address.innerText = data["address"];
			td_phone.setAttribute("id", "customer_phone_" + data["id"]);
			td_address.setAttribute("id", "customer_address_" + data["id"]);
			tr.setAttribute("id", "customer_" + data["id"]);
			button_remove.setAttribute("onclick", "vac_remove_customer(" + data["id"] + ")");
			button_remove.innerText = "Xóa";
			button_update.setAttribute("onclick", "vac_get_update_customer(" + data["id"] + ", '" + data["name"] + "', '" + data["phone"] + "', '" + data["address"] + "')");
			button_update.innerText = "Cập nhật";
			td_button.appendChild(button_remove);
			td_button.appendChild(button_update);
			tr.appendChild(td_name);
			tr.appendChild(td_phone);
			tr.appendChild(td_address);
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

function vac_get_update_customer(id, name, phone, address) {
	document.getElementById("customer").value = name;
	document.getElementById("phone").value = phone;
	document.getElementById("address").value = address;
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
				document.getElementById("customer_name_" + data["id"]).innerText = data["name"];
				document.getElementById("customer_phone_" + data["id"]).innerText = data["phone"];
				document.getElementById("customer_address_" + data["id"]).innerText = data["address"];			
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

function vac_add_pet(customerid) {
	var petname = prompt("Nhập tên thú cưng: ", "");
	if(petname) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
		post_data = ["action=addpet", "id=" + customerid, "petname=" + petname];
		fetch(url, post_data).then(response => {
			// console.log(response);
			
			var msg = "";
			if(response) {
				var data = JSON.parse(response);
				var tr = document.createElement("tr");
				var td_name = document.createElement("td");
				var a_name = document.createElement("a");
				var td_lasttime = document.createElement("td");
				var td_lastname = document.createElement("td");
				var td_button = document.createElement("td");
				var button_remove = document.createElement("button");
				var button_update = document.createElement("button");
				a_name.innerText = data["petname"];
				a_name.setAttribute("href", "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=patient&petid="+data["id"]);
				a_name.setAttribute("id", "pet_name" + data["id"]);
				td_name.appendChild(a_name);
				button_remove.setAttribute("onclick", "vac_remove_pet(" + data["id"] + ")");
				button_remove.innerText = "Xóa";
				button_update.setAttribute("onclick", "vac_update_pet(" + data["id"] + ")");
				button_update.innerText = "Cập nhật";
				td_button.appendChild(button_remove);
				td_button.appendChild(button_update);
				tr.appendChild(td_name);
				tr.appendChild(td_lastname);
				tr.appendChild(td_lasttime);
				tr.appendChild(td_button);
				document.getElementById("vac_body").appendChild(tr);
				msg = "Thêm thành công";
			}
			else {
				msg = "Chưa thêm được";
			}
			showMsg(msg);
		})
	}  
}

function vac_remove_pet(id) {
	if(confirm("Bạn có muốn xóa thú cưng này không?")) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
		post_data = ["action=removepet", "id=" + id];
		fetch(url, post_data).then(response => {
			var msg = "";
			if(response) {
				document.getElementById("pet_" + id).remove();
				msg = "Xóa thành công";
			}
			else {
				msg = "Chưa xoá được";
			}
			showMsg(msg);
		})			
	}
}

function vac_update_pet(id) {
	if(id) {
		var petname = prompt("Nhập tên thú cưng: ", "");
		if(petname) {				
			var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
			var data = document.getElementsByClassName("vac_val");
			var post_data = ["action=updatepet", "id=" + id, "petname=" + petname];
			var length = data.length;
			for (let index = 0; index < length; index++) {
				post_data.push(data[index].getAttribute("name") + "=" + data[index].value);
			};
			fetch(url, post_data).then(response => {	
				if(response) {
					var data = JSON.parse(response);
					
					document.getElementById("pet_name_" + id).innerText = petname;
					msg = "Cập nhật thành công";
				}
				else {
					msg = "Chưa cập nhật được";
				}
				showMsg(msg);
			})
		}
	}
}

function ex(id) {
	var diseaseid = document.getElementById("disease").value;
	var disease = trim(document.getElementById("disease").selectedOptions[0].innerText);
	var cometime = document.getElementById("cometime").value;
	var calltime = document.getElementById("calltime").value;

	var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=patient";
	var post_data = ["action=addvac", "petid=" + id, "diseaseid=" + diseaseid, "disease=" + disease, "cometime=" + cometime, "calltime=" + calltime];
	fetch(url, post_data).then(response => {
		// console.log(response);
		if(response) {
			var data = JSON.parse(response);
			// console.log(data);
			var tr = document.createElement("tr");
			var td_disease = document.createElement("td");
			var td_cometime = document.createElement("td");
			var td_calltime = document.createElement("td");
			var td_confirm = document.createElement("td");
			var td_button = document.createElement("td");
			var button_remove = document.createElement("button");
			tr.setAttribute("id", "vac_" + data["id"]);
			td_disease.innerText = disease;
			td_calltime.innerText = data["calltime"];
			td_cometime.innerText = data["cometime"];
			td_confirm.innerText = data["confirm"];
			button_remove.setAttribute("onclick", "vac_remove_vac(" + data["id"] + ", " + diseaseid + ")");
			button_remove.innerText = "Xóa";
			td_button.appendChild(button_remove);
			tr.appendChild(td_disease);
			tr.appendChild(td_calltime);
			tr.appendChild(td_cometime);
			tr.appendChild(td_confirm);
			tr.appendChild(td_button);
			document.getElementById("vac_body").appendChild(tr);
		}
	})
	return false;
}

function vac_remove_vac(id, diseaseid) {
	if(confirm("Bạn có muốn xóa bản ghi này không?")) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=patient";
		post_data = ["action=removevac", "id=" + id, "diseaseid=" + diseaseid];
		fetch(url, post_data).then(response => {
			var msg = "";
			if(response) {
				document.getElementById("vac_" + id).remove();
				msg = "Xóa thành công";
			}
			else {
				msg = "Chưa xoá được";
			}
			showMsg(msg);
		})			
	}
}


function showMsg(msg) {
	$("#e_notify").show();
	$("#e_notify").text(msg);
	setTimeout(() => {
		$("#e_notify").fadeOut();
	}, 1000);
}

function alert_msg(msg) {
	$('#msgshow').html(msg); 
	$('#msgshow').show('slide').delay(2000).hide('slow'); 
}

function grinError(e) {
	e.css("border", "1px solid red");
	setTimeout(() => {
		e.css("border", "");
	}, 1000);
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
  g_index = index;
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
            g_index = customer_list.length;
            customer_list.push(customer_data);
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
