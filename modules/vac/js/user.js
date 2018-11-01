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
	}, 1000);
}
