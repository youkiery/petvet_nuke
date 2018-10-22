<!-- BEGIN: main -->
<form id="vac_panel" onsubmit="return vac_add_customer()">
	<label for="customer">
		{lang.customer}
	</label>
	<input class="vac_val" style="display: block;" type="text" name="customer" id="customer">
	<label for="phone">
		{lang.phone}
	</label>
	<input class="vac_val" style="display: block;" type="number" maxlength="15" name="phone" id="phone">
	<label for="note">
		{lang.note}
	</label>
	<input class="vac_val" style="display: block;" type="text" name="note" id="note">
	<input type="submit" id="vac_button_panel" value="{lang.add}">
</form>
<button id="update" onclick="vac_update_customer(-1)">
	{lang.update}
</button>
<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
<div class="vng_body" style="height: 426px;overflow-y: scroll;">
	<table class="vng_vacbox tab1">
		<thead>
			<tr>
				<th>
					{lang.customer}
				</th>				
				<th>
					{lang.phone}
				</th>				
				<th>
					{lang.note}
				</th>				
				<th>
					
				</th>
			</tr>
		</thead>
		<tbody id="vac_body">
			<!-- BEGIN: customer -->		
			<tr id="customer_{index}">
				<td id="customer_name_{index}">
					{name}
				</td>				
				<td id="customer_phone_{index}">
					{phone}
				</td>				
				<td id="customer_note_{index}">
					{note}
				</td>
				<td>
					<button onclick="vac_remove_customer({index})">
						{lang.remove}
					</button>
					<button onclick="vac_get_update_customer({index}, '{name}', '{phone}', '{note}')">
						{lang.update}
					</button>
				</td>
			</tr>
			<!-- END: customer -->
		</tbody>
	</table>
</div>
<!-- END: main -->