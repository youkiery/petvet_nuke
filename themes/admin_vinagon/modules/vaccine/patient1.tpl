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
	<table class="vng_vacbox tab1">
		<thead>
			<tr>
				<th>
					{lang.disease}
				</th>				
				<th>
					{lang.vaccome}
				</th>				
				<th>
					{lang.vaccall}
				</th>				
				<th>
					{lang.confirm}
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
			</tr>
			<!-- END: vac -->
		</tbody>
	</table>
</div>
<script>

</script>
<!-- END: main -->