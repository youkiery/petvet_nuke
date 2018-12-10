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
				{lang.phone}
			</th>
			<th>
				{lang.doctor}
			</th>
			<th>
				{lang.ngaysieuam}
			</th>
			<th>
				{lang.ngaydusinh}
			</th>
			<th>
			
			</th>
		</tr>
	</thead>
	<tbody>
		<!-- BEGIN: row -->
		<tr id="ss_{id}">
			<td>
				{stt}
			</td>
			<td>
				{petname}
			</td>
			<td>
				{customer}
			</td>
			<td>
				{phone}
			</td>
			<td>
				{doctor}
			</td>
			<td>
				{cometime}
			</td>
			<td>
				{calltime}
			</td>
			<td>
				<button onclick="xoasieuam({id})">
					{lang.remove}
				</button>
			</td>
		</tr>
		<!-- END: row -->
	</tbody>
</table>
<div id="nav_link">
		{nav_link}
	</div>
<!-- END: main -->
