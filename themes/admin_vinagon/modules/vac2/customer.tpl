<!-- BEGIN: main -->
<form id="vac_panel"  onsubmit="return vac_add_customer()">
	<table class="tab1">
		<tbody>
			<tr>
				<td>
					<label for="customer">
						{lang.customer}
					</label>
				</td>
				<td>
					<input class="vac_val" style="display: block;" type="text" name="customer" id="customer">
				</td>
				<td rowspan="2">
					<label for="address">
						{lang.address}
					</label>
				</td>
				<td rowspan="2">
					<input class="vac_val" style="display: block; height: 40px;" type="text" name="address" id="address">
				</td>
			</tr>
			<tr>
				<td>
					<label for="phone">
						{lang.phone}
					</label>
				</td>
				<td>
					<input class="vac_val" style="display: block;" type="number" maxlength="15" name="phone" id="phone">
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center;">
					<input type="submit" id="vac_button_panel" value="{lang.add}">
					<input type="button" id="update" onclick="vac_update_customer(-1)" value="{lang.update}">
				</td>
			</tr>
		</tbody>
	</table>
</form>
<form method="GET">
	<input type="hidden" name="nv" value="vac">
	<input type="hidden" name="op" value="customer">
	<select name="sort">
		<!-- BEGIN: fs_option -->
		<option value="{fs_value}" {fs_select}>
			{fs_name}
		</option>
		<!-- END: fs_option -->
	</select>
	<select name="filter">
		<!-- BEGIN: ff_option -->
		<option value="{ff_value}" {ff_select}>
			{ff_name}
		</option>
		<!-- END: ff_option -->
	</select>
	<input type="text" name="key" value="{keyword}">
	<button>
		{lang.search}
	</button>
</form>
<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
<p>
  {filter_count}
</p>
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
					{lang.address}
				</th>				
				<th>
					
				</th>
			</tr>
		</thead>
		<tbody id="vac_body">
			<!-- BEGIN: customer -->		
			<tr id="customer_{index}">
				<td>
					<a href="{detail_link}" id="customer_name_{index}">
						{name}
					</a>
				</td>
				<td id="customer_phone_{index}">
					{phone}
				</td>				
				<td id="customer_address_{index}">
					{address}
				</td>
				<td>
					<button onclick="vac_remove_customer({index})">
						{lang.remove}
					</button>
					<button onclick="vac_get_update_customer({index}, '{name}', '{phone}', '{address}')">
						{lang.update}
					</button>
				</td>
			</tr>
			<!-- END: customer -->
		</tbody>
	</table>
</div>
<div>
	{nav_link}
</div>
<!-- END: main -->