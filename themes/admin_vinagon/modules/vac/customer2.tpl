<!-- BEGIN: main -->
<div>
		<p>
			{lang.customer}: {name}
		</p>
		<p>
			{lang.phone}: {phone}
		</p>
		<p>
			{lang.note}: {note}
		</p>
		<button onclick="vac_add_pet({customerid})">
			{lang.add}
		</button>
		<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
		<table class="vng_vacbox tab1">
			<thead>
				<tr>
					<th>
						{lang.petname}
					</th>
					<th>
						{lang.lasttime}
					</th>				
					<th>
						{lang.lastname}
					</th>
					<th>
					</th>
				</tr>			
			</thead>
			<tbody id="vac_body">
				<!-- BEGIN: vac -->
				<tr id="pet_{id}">
					<td>
						<a href="{detail_link}" id="pet_name_{id}">
							{petname}
						</a>
					</td>
					<td>
						{lasttime}
					</td>
					<td>
						{lastname}
					</td>
					<td>
						<button onclick="vac_remove_pet({id})">
							{lang.remove}
						</button>
						<button onclick="vac_update_pet({id})">
							{lang.update}
						</button>
					</td>
				</tr>
				<!-- END: vac -->
			</tbody>
	
	</div>
	<!-- END: main -->
	