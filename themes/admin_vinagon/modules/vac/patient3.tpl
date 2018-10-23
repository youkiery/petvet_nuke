<!-- BEGIN: main -->
	<div class="vng_body" style="height: 426px;overflow-y: scroll;">
		<table class="vng_vacbox tab1">
			<thead>
				<tr>
					<th>
						{lang.index}
					</th>				
					<th>
						{lang.petname}
					</th>				
					<th>
						{lang.customer}
					</th>
					<th>
						{lang.phone}
					</th>
				</tr>
			</thead>
			<tbody id="vac_body">
				<!-- BEGIN: patient -->		
				<tr id="patient_{index}">
					<td id="patient_index_{index}">
						{index}
					</td>				
					<td>
						<a href="{detail_link}"  id="patient_petname_{index}">
							{petname}
						</a>
					</td>				
					<td>
						<a href="{detail_link2}"  id="patient_customer_{index}">
							{customer}
						</a>
					</td>				
					<td id="patient_phone_{index}">
						{phone}
					</td>
				</tr>
				<!-- END: patient -->
			</tbody>
		</table>
	</div>
	<!-- END: main -->