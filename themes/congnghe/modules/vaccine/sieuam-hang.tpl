<!-- BEGIN: main -->
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
        <th>
          {lang.usgcome}
        </th>  
        <th>
          {lang.usgcall}
        </th>  
				<th>
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
						<!-- BEGIN: birth -->
						<button id='birth_{index}' onclick='birth({index}, {vacid}, {petid})' {checked}>{birth}</button>
						<!-- END: birth -->
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
			<tr>
				<td colspan="9">
					<p style="float: right;">
						{nav}
					</p>
				</td>
			</tr>
  	</tbody>
	</table>
<br>
<!-- END: main -->
