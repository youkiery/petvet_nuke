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
				{lang.ngaybao}
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
				{sieuam}
			</td>
			<td>
				{dusinh}
			</td>
			<td>
				{ngaybao}
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
