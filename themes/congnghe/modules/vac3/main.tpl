<!-- BEGIN: main -->
	<style>
		td, th {
			padding: 4px;
		}
	</style>
	<table border="1" style="border-collapse: collapse;">
		<thead>
			<tr>
				<th>
					ID
				</th>
				<th>
					Tên thuốc
				</th>
				<th>
					Hình ảnh
				</th>
				<th>
					Giá bán
				</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: row -->
			<tr>
				<td>
					{id}
				</td>
				<td style="text-transform: capitalize">
					{name}
				</td>
				<td>
					<img width="240" height="240" src="{image}" alt="">
				</td>
				<td style="color: red">
					{price}
				</td>
			</tr>
			<!-- END: row -->
		</tbody>
	</table>
<!-- END: main -->
