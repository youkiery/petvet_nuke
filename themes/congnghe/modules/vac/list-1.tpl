<!-- BEGIN: disease -->
<table class="vng_vacbox tab1">
  	<thead>
    	<tr>
      	<th colspan="7" class="vng_vacbox_title" style="text-align: center">
        	{title}
      	</th>
    	</tr>
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
        	{lang.cometime}
      	</th>    
      	<th>
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
				<td>
					<button onclick="confirm_lower({index}, {vacid}, {diseaseid})">
						&lt;
					</button>
          <div id="vac_confirm_{index}">
            {confirm}
          </div>
					<button onclick="confirm_upper({index}, {vacid}, {diseaseid})">
						&gt;
					</button>
				</td>
    	</tr>
    	<!-- END: vac_body -->
  	</tbody>
	</table>
</div>
<br>
<!-- END: disease -->
