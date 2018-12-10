<!-- BEGIN: main -->
<form id="vac" onsubmit="return vac_submit_disease()">
	<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
	<input id="{index}" type="button" value="{lang.add}" onclick="vac_disease_add(this)">
	<input type="submit" value="{lang.save}">
	<!-- BEGIN: disease -->
	<div id="vac_remove_{index}">
		<input style="text-transform:capitalize;" class="vac_val" name="d_name[{index}]" type="text" value="{name}" />
		<input type="button" value="{lang.remove}" onclick="vac_disease_remove({index})">
	</div>
	<!-- END: disease -->
</form>
<script>
function vac_disease_add(e) {
	var index = Number(e.getAttribute("id"))  + 1;
	e.setAttribute("id", index);
	var form = document.getElementById("vac");
	var html = '<div id="vac_remove_' + index + '"> <input style="text-transform:capitalize;" class="vac_val" name="d_name[' + index + ']" type="text" /> <input type="button" value="{lang.remove}" onclick="vac_disease_remove(' + index + ')"> </div>';
	form.innerHTML += html;
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
			window.location.reload()
		}
		else {
			msg = "Chưa cập nhật";
		}
		showMsg(msg);
	})

	return false;
}
</script>
<!-- END: main -->
