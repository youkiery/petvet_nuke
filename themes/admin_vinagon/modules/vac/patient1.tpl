<!-- BEGIN: main -->
<div>
	<ul class="vac_list">
		<li>
			{lang.petname}: {name}
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
<!-- END: main -->