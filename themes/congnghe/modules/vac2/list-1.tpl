<!-- BEGIN: disease -->
	<table class="vng_vacbox tab1">
  	<thead>
    	<tr>
      	<th colspan="9" class="vng_vacbox_title" style="text-align: center">
        	{title}
      	</th>
    	</tr>
    	<tr>
        <th style="width: 20px;">
          {lang.index}
        </th>  
        <th style="width: 70px;">
          {lang.petname}
        </th>  
        <th style="width: 120px;">
          {lang.customer}
        </th>  
        <th style="width: 80px;">
          {lang.phone}
        </th>  
        <th style="width: 50px;">
          {lang.disease}
        </th>  
        <th style="width: 50px;">
          {lang.cometime}
        </th>  
        <th style="width: 50px;">
          {lang.calltime}
        </th>  
      	<th style="width: 80px;">
        	{lang.confirm}
				</th>
				<th>
					{lang.note}
				</th>
    	</tr>
  	</thead>
  	<tbody>
    	<!-- BEGIN: vac_body -->  
    	<tr style="background: {bgcolor}; text-transform: capitalize;">
      	<td>
        	{index}
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
        	{disease}
				</td>    
      	<td>
        	{cometime}
      	</td>    
      	<td>
        	{calltime}
				</td>    
				<td style="text-align: center;">
					<button style="float: left;" onclick="confirm_lower({index}, {vacid}, {petid}, {diseaseid})">
						&lt;
					</button>
          <span id="vac_confirm_{diseaseid}_{index}" style="color: {color};">
            {confirm}
          </span>
					<button style="float: right;" onclick="confirm_upper({index}, {vacid}, {petid}, {diseaseid})">
						&gt;
					</button>
					<!-- BEGIN: recall_link -->
						<button id="recall_{index}" onclick="recall({index}, {vacid}, {petid}, {diseaseid})">
							{lang.recall}
						</button>
					<!-- END: recall_link -->
				</td>
				<td>
					<img class="mini-icon" src="/uploads/vac/note_add.png" alt="thêm ghi chú" onclick="editNote({vacid}, {diseaseid})">
					<img class="mini-icon" src="/uploads/vac/note_info.png" alt="xem ghi chú" onclick="viewNote({vacid}, {diseaseid})">
				</td>
			</tr>
			<tr style="display: none; background: #fa0;" id="note_{diseaseid}_{vacid}">
				<td colspan="9" id="note_v{diseaseid}_{vacid}">
					{note}
				</td>
			</tr>
    	<!-- END: vac_body -->
  	</tbody>
	</table>
<br>
<!-- END: disease -->
