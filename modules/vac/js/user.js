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
	var e_notify = document.getElementById("vac_notify");
	e_notify.innerText = msg;
	e_notify.style.display = "block";
	e_notify.style.opacity = 1;
	clearInterval(interval);
	setTimeout(() => {
		timer = 0;
		interval = setInterval(() => {
			if(Math.floor(timer / 10)) {
				clearInterval(interval);
				e_notify.style.display = "none";
				e_notify.style.opacity = 0;
			}
			timer ++;
			e_notify.style.opacity *= 0.75;
		}, 30)
	}, 1000)
}
