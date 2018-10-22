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
						{lang.note}
					</th>				
					<th>
						
					</th>
				</tr>
			</thead>
			<tbody id="vac_body">
				<!-- BEGIN: patient -->		
				<tr id="patient_{index}">
					<td id="patient_name_{index}">
						{name}
					</td>				
					<td id="patient_phone_{index}">
						{phone}
					</td>				
					<td id="patient_note_{index}">
						{note}
					</td>
					<td>
						<button onclick="vac_remove_patient({index})">
							{lang.remove}
						</button>
						<button onclick="vac_get_update_patient({index}, '{name}', '{phone}', '{note}')">
							{lang.update}
						</button>
					</td>
				</tr>
				<!-- END: patient -->
			</tbody>
		</table>
	</div>
	<!-- END: main -->