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