<!-- BEGIN: main -->
<form id="vac" onsubmit="return vac_submit_disease()">
	<div id="vac_notify" style="color: orange; background: gray; width: fit-content; display: none;"> Chọn hành động </div>
	<input id="{index}" type="button" value="{lang.add}" onclick="vac_disease_add(this)">
	<input type="submit" value="{lang.save}">
	<!-- BEGIN: disease -->
	<div id="vac_remove_{index}">
		<input class="vac_val" name="d_name[{index}]" type="text" value="{name}" />
		<input type="button" value="{lang.remove}" onclick="vac_disease_remove({index})">
	</div>
	<!-- END: disease -->
</form>
<!-- END: main -->
