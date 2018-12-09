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
          {lang.ngaysieuam}
        </th>  
        <th style="width: 50px;">
          {lang.ngaydusinh}
        </th>  
      	<th style="width: 50px;">
        	{lang.ngaybao}
				</th>    
				<th style="width: 70px;">
					{lang.confirm}
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
      	<td class="thongbao">
        	{thongbao}
				</td>    
				<td style="text-align: center;">
					<button style="float: left;" onclick="confirm_lower({index}, {vacid}, {petid})">
						&lt;
					</button>
          <span id="vac_confirm_{index}" style="color: {color};">
            {trangthai}
          </span>
					<button style="float: right;" onclick="confirm_upper({index}, {vacid}, {petid})">
						&gt;
					</button>
				</td>
    	</tr>
    	<!-- END: list -->
  	</tbody>
	</table>
<br>
<!-- END: main -->
