<!-- BEGIN: main -->
<table class="tab1">
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
				{lang.doctor}
			</th>
			<th>
				{lang.treat_day}
			</th>
			<th>
				{lang.pet_status}
			</th>
			<th>
				{lang.insult}
			</th>
			<th>
			
			</th>
		</tr>
	</thead>
	<tbody>
		<!-- BEGIN: row -->
		<tr id="{id}" style="background: {bgcolor}">
			<td class="index">
				{stt}
			</td>
			<td class="petname">
				{petname}
			</td>
			<td class="customer">
				{customer}
			</td>
			<td class="doctor">
				{doctor}
			</td>
			<td class="luubenh">
				{luubenh}
			</td>
			<td class="tinhtrang">
				{tinhtrang}
			</td>
			<td class="ketqua">
				{ketqua}
			</td>
			<td>
				<button onclick="delete_treat({id})">
					{lang.remove}
				</button>
				<button onclick="update(event, {id})">
					{lang.update}
				</button>
			</td>
      <td style="display: none;" class="lieutrinh">
        {lieutrinh}
      </td>
		</tr>
		<!-- END: row -->
	</tbody>
</table>
<div id="nav_link">
		{nav_link}
	</div>
<!-- END: main -->
