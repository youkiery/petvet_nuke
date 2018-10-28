<!-- BEGIN: disease -->
	<table class="vng_vacbox tab1">
  	<thead>
    	<tr>
      	<th colspan="7" class="vng_vacbox_title" style="text-align: center">
        	{title}
      	</th>
    	</tr>
    	<tr>
        <th style="width: 20px;">
          {lang.index}
        </th>  
        <th style="width: 120px;">
          {lang.petname}
        </th>  
        <th style="width: 140px;">
          {lang.customer}
        </th>  
        <th style="width: 100px;">
          {lang.phone}
        </th>  
        <th style="width: 100px;">
          {lang.cometime}
        </th>  
        <th style="width: 100px;">
          {lang.calltime}
        </th>  
      	<th>
        	{lang.confirm}
      	</th>    
    	</tr>
  	</thead>
  	<tbody>
    	<!-- BEGIN: vac_body -->  
    	<tr>
      	<td id="vac_{id}">
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
        	{cometime}
      	</td>    
      	<td>
        	{calltime}
				</td>    
				<td style="text-align: center;">
					<button style="float: left;" onclick="confirm_lower({index}, {vacid}, {diseaseid})">
						&lt;
					</button>
          <span id="vac_confirm_{index}">
            {confirm}
          </span>
					<button style="float: right;" onclick="confirm_upper({index}, {vacid}, {diseaseid})">
						&gt;
					</button>
				</td>
    	</tr>
    	<!-- END: vac_body -->
  	</tbody>
	</table>
<br>
<!-- END: disease -->