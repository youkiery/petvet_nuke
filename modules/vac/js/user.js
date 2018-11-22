var timer = 0;
var interval;

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
	}, 5000);
}

function alert_msg(msg) {
	$('#msgshow').html(msg); 
	$('#msgshow').show('slide').delay(2000).hide('slow'); 
}

function nv_open_browse_file(a,b,c,d,e){LeftPosition=screen.width?(screen.width-c)/2:0;TopPosition=screen.height?(screen.height-d)/2:0;settings="height="+d+",width="+c+",top="+TopPosition+",left="+LeftPosition;e!==""&&(settings=settings+","+e);window.open(a,b,settings);window.blur()}function nv_sh(a,b){document.getElementById(a).options[document.getElementById(a).selectedIndex].value==3?nv_show_hidden(b,1):nv_show_hidden(b,0);return!1}

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
