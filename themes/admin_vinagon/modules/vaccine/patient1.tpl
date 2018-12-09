<!-- BEGIN: main -->
<div>
	<ul class="vac_list">
		<li>
			{lang.petname}: {petname}
		</li>
		<li>
			{lang.customer}: {customer}
		</li>
		<li>
			{lang.phone}: {phone}
		</li>
	</ul>
	<!-- <div style="display:none;"> -->
			<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
			<form onsubmit="return ex({id})">
		<table class="tab1">
			<thead>
				<tr>
					<th>
						{lang.disease}
					</th>
					<th>
						{lang.cometime}
					</th>
					<th>
						{lang.calltime}
					</th>
					<th> </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<select id="disease">
							<!-- BEGIN: option -->
							<option value="{diseaseid}">
								{diseasename}
							</option>
							<!-- END: option -->				
						</select>
					</td>
					<td>
						<input type="date" name="date" value="{time}" id="cometime">
					</td>
					<td>
						<input type="date" name="date" value="{time2}" id="calltime">
					</td>
					<td>
						<input type="submit" value="{lang.add}">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<table class="vng_vacbox tab1">
		<thead>
			<tr>
				<th>
					{lang.disease}
				</th>				
				<th>
					{lang.cometime}
				</th>				
				<th>
					{lang.calltime}
				</th>				
				<th>
					{lang.confirm}
				</th>
				<th>
					
				</th>
			</tr>
		</thead>
		<tbody id="vac_body">
			<!-- BEGIN: vac -->
			<tr id="vac_{index}">
				<td>
					{disease}
				</td>
				<td>
					{cometime}
				</td>
				<td>
					{calltime}
				</td>
				<td id="vac_comfirm_{index}">
					{confirm}
				</td>
				<td>
					<button onclick="vac_remove_vac({index})">
						{lang.remove}
					</button>
				</td>
			</tr>
			<!-- END: vac -->
		</tbody>
	</table>
</div>
<script>
function ex(id) {
	var diseaseid = document.getElementById("disease").value;
	var disease = trim(document.getElementById("disease").selectedOptions[0].innerText);
	var cometime = document.getElementById("cometime").value;
	var calltime = document.getElementById("calltime").value;

	var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=patient";
	var post_data = ["action=addvac", "petid=" + id, "diseaseid=" + diseaseid, "disease=" + disease, "cometime=" + cometime, "calltime=" + calltime];
	fetch(url, post_data).then(response => {
		if(response) {
			window.location.reload()
		}
	})
	return false;
}

function vac_remove_vac(id, diseaseid) {
	if(confirm("Bạn có muốn xóa bản ghi này không?")) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=patient";
		post_data = ["action=removevac", "id=" + id];
		fetch(url, post_data).then(response => {
			var msg = "";
			if(response) {
				window.location.reload()
			}
			else {
				msg = "Chưa xoá được";
			}
			showMsg(msg);
		})			
	}
}

</script>
<!-- END: main -->