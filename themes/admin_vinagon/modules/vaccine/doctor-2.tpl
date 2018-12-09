<!-- BEGIN: main -->
<ul id="doctor_list">
	<!-- BEGIN: doctor -->
	<li>
		<span id="name_{index}">
			{name}
		</span>
		<span onclick="edit({index})" style="float: right; border: 1px solid #ddd; width: 20px; height: 20px; line-height: 20px; margin-left: 4px; cursor: pointer;">
			Sửa
		</span>
		<span onclick="del({index})" class="doc_del" style="float: right; border: 1px solid #ddd; width: 20px; height: 20px; line-height: 20px; margin-left: 4px; cursor: pointer;">
			Xóa
		</span>
	</li>
	<!-- END: doctor -->
</ul>
<!-- END: main -->
