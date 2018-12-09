<!-- BEGIN: main -->
<div>
		<p>
			{lang.customer}: {customer}
		</p>
		<p>
			{lang.phone}: {phone}
		</p>
		<p>
			{lang.address}: {address}
		</p>
		<button onclick="vac_add_pet({customerid})">
			{lang.add}
		</button>
		<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
		<table class="vng_vacbox tab1">
			<thead>
				<tr>
					<th>
						{lang.petname}
					</th>
					<th>
						{lang.lasttime}
					</th>				
					<th>
						{lang.lastname}
					</th>
					<th>
					</th>
				</tr>			
			</thead>
			<tbody id="vac_body">
				<!-- BEGIN: vac -->
				<tr id="pet_{id}">
					<td>
						<a href="{detail_link}" id="pet_name_{id}">
							{petname}
						</a>
					</td>
					<td>
						{lasttime}
					</td>
					<td>
						{lastname}
					</td>
					<td>
						<button onclick="vac_remove_pet({id})">
							{lang.remove}
						</button>
						<button onclick="vac_update_pet({id}, '{petname}')">
							{lang.update}
						</button>
					</td>
				</tr>
				<!-- END: vac -->
			</tbody>
	
	</div>
	<script>
		function vac_add_pet(customerid) {
	var petname = prompt("Nhập tên thú cưng: ", "");
	if(petname) {
		var url = "index.php?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=customer";
		post_data = ["action=addpet", "id=" + customerid, "petname=" + petname];
		fetch(url, post_data).then(response => {
			// console.log(response);
			
			var msg = "";
			if(response) {
				window.location.reload()
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
				window.location.reload()
			}
			else {
				msg = "Chưa xoá được";
			}
			showMsg(msg);
		})			
	}
}

function vac_update_pet(id, petname) {
	if(id) {
		var petname = prompt("Nhập tên thú cưng: ", petname);
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
					window.location.reload()
				}
				else {
					msg = "Chưa cập nhật được";
				}
				showMsg(msg);
			})
		}
	}
}

</script>
<!-- END: main -->
	