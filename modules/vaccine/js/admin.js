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
  customer_name.value = customer_data["name"];
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
            customer_data["pet"].push(response["data"]);
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
    html += "<option value='"+ pet_data["id"] +"'>" + pet_data["name"] + "</option>";
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
        html += '<div class=\"temp\" style=\"padding: 8px 4px;border-bottom: 1px solid black;overflow: overlay; text-transform: capitalize;\" onclick=\"getInfo(\'' + index + '\')\"><span style=\"float: left;\">' + data.name + '</span><span style=\"float: right;\">' + data.phone + '</span></div>';
      })
      suggest.style.display = "block";
    }
    else {
      suggest.style.display = "note";
    }
    suggest.innerHTML = html;
  })
}
function suggest_init() {
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
}

function update_customer(id) {
  window.location.replace(adlink + "customer&pan=update&id=" + id);
}
function update_pet(id, petname) {
  var confirm = prompt("Nhập tên thú cưng mới", petname)
  console.log(petname);
  if (confirm) {
    $.post(
      adlink + "customer",
      {
        action: "updatepet", id: id, petname: confirm
      },
      (response, status) => {
        console.log(response);
        
        var data = JSON.parse(response)
        if (data) {
          g_pet = confirm
        }
      }
    )
  }
}

