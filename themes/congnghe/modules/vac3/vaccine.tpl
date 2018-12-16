<!-- BEGIN: main -->
<form autocomplete="off">
	<table class="tab1">
		<thead>
			<tr>
				<th colspan="2" class="title">
					{lang.main_title}
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
          <label> {lang.customer} </label>
					<input id="customer" class="suggest_input" type="text">
          <div class="suggest" style="display: none">a</div>
				</td>
				<td class="suggest_wrap">
          <label> {lang.phone} </label>
          <input id="phone" class="suggest_input" type="text">
          <div class="suggest" style="display: none">a</div>
				</td>
      </tr>
      <tr>
        <td colspan="2">
          <label> {lang.address} </label>
          <input id="address" type="text">
        </td>
      </tr>
			<tr>
        <td>
          <label> {lang.pet} </label>
					<select id="pet"></select>
				</td>
				<td>
          <label> {lang.disease} </label>
          <select id="disease">
						<!-- BEGIN: disease -->
						<option value="{diseaseid}"> {disease} </option>
						<!-- END: disease -->
					</select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label> {lang.doctor} </label>
          <select id="disease">
            <!-- BEGIN: doctor -->
            <option value="{doctorid}"> {doctor} </option>
            <!-- END: doctor -->
          </select>
        </td>
      </tr>
      <tr>
				<td>
          <label> {lang.vaccome} </label>
					<input id="cometime" type="date" value="{cometime}">
				</td>
				<td>
          <label> {lang.vaccall} </label>
					<input id="calltime" type="date" value="{calltime}">
				</td>
			</tr>
			<!-- note & submit -->
			<tr>
				<td colspan="2">
          <label> {lang.note} </label>
					<textarea id="pet_note" rows="3"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
          <input type="submit" value="{lang.add}" class="full">
				</td>
			</tr>
		</tbody>
	</table>
</form>
<!-- END: main -->
