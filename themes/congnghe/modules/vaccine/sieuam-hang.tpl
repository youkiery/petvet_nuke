<!-- BEGIN: main -->
<table class="vng_vacbox tab1">
  	<thead>
    	<tr>
        <th style="width: 20px;">
          {lang.index}
        </th>  
        <th style="width: 100px;">
          {lang.petname}
        </th>  
        <th style="width: 120px;">
          {lang.customer}
        </th>  
        <th style="width: 100px;">
          {lang.phone}
        </th>  
        <th style="width: 50px;">
          {lang.usgcome}
        </th>  
        <th style="width: 50px;">
          {lang.usgcall}
        </th>  
				<th style="width: 70px;">
					{lang.usgconfirm}
				</th>
				<th>
					{lang.note}
				</th>
    	</tr>
  	</thead>
  	<tbody>
    	<!-- BEGIN: list -->  
    	<tr style="background: {bgcolor}; text-transform: capitalize;" img="{image}">
      	<td>
        	{index}
      	</td>    
      	<td class="petname">
        	{petname}
      	</td>    
      	<td class="customer">
        	{customer}
      	</td>
      	<td class="nphone">
        	{phone}
      	</td>    
      	<td class="sieuam">
        	{sieuam}
				</td>    
      	<td class="dusinh">
        	{dusinh}
      	</td>    
				<td style="text-align: center;">
					<button style="float: left;" onclick="confirm_lower({index}, {vacid}, {petid})">
						&lt;
					</button>
          <span id="vac_confirm_{index}" style="color: {color};">
            {status}
          </span>
					<button style="float: right;" onclick="confirm_upper({index}, {vacid}, {petid})">
						&gt;
					</button>
				</td>
				<td>
					<img class="mini-icon" src="/uploads/vac/note_add.png" alt="thêm ghi chú" onclick="editNote({vacid})">
					<img class="mini-icon" src="/uploads/vac/note_info.png" alt="xem ghi chú" onclick="viewNote({vacid})">
				</td>
			</tr>
			<tr style="display: none; background: #fa0;" id="note_{vacid}">
				<td colspan="9" id="note_v{vacid}">
					{note}
				</td>
			</tr>
		<!-- END: list -->
  	</tbody>
	</table>
<br>
<!-- END: main -->
