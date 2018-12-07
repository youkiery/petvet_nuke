<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify" style="display: none; position: fixed; top: 0; right: 0; background: white; padding: 8px; border: 1px solid black; z-index: 1000;"></div>
<div id="reman"></div>
<ul>
  <li>
    <a href="{list}"> {lang.list} </a>
  </li>
  <li>
    <a href="{rlist}"> {lang.list2} </a>
  </li>
</ul>
<div id="vac_panel" style="display: none; position: fixed; margin:auto; z-index: 1001;">
  <form>
    <table class="tab1" style="width: 500px;">
      <thead>
        <tr>
          <td colspan="2" style="text-align: center">
            {lang.confirm_mess}
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {lang.recall}
          </td>
          <td style="width: 60%;">
            <input id="confirm_recall" type="date">
          </td>
        </tr>
        <tr>
          <td>
            {lang.doctor}
          </td>
          <td>
            <select id="confirm_doctor" style="width: 100%; height: 2em;">
            </select>      
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center">
            <input type="button" style="height: 2em; padding: 4px;" onclick="save_form()" value="{lang.save}">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<form class="vac_form" action="/index.php">
  <input type="hidden" name="nv" value="vac2">
  <input type="hidden" name="op" value="usg-list">
  <input type="hidden" name="page" value="{page}">
  <input type="text" name="keyword" value="{keyword}">
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<div id="disease_display">
<!-- BEGIN: disease -->
<table class="vng_vacbox tab1">
  	<thead>
    	<tr>
      	<th colspan="9" class="vng_vacbox_title" style="text-align: center">
        	{lang.main_title}
      	</th>
    	</tr>
    	<tr>
        <th style="width: 20px;">
          {lang.index}
        </th>  
        <th style="width: 100px;">
          {lang.petname}
        </th>  
        <th style="width: 130px;">
          {lang.customer}
        </th>  
        <th style="width: 80px;">
          {lang.phone}
        </th>  
        <th style="width: 50px;">
          {lang.usgcometime}
        </th>  
        <th style="width: 50px;">
          {lang.usgcalltime}
        </th>  
      	<th style="width: 100px;">
        	{lang.confirm}
				</th>
				<th>
					{lang.note}
				</th>
    	</tr>
  	</thead>
  	<tbody>
    	<!-- BEGIN: body -->  
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
        	{cometime}
      	</td>    
      	<td>
        	{calltime}
				</td>    
				<td style="text-align: center;">
					<button style="float: left;" onclick="confirm_lower({index}, {vacid}, {petid})">
						&lt;
					</button>
          <span id="vac_confirm_{index}" style="color: {color};">
            {confirm}
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
    	<!-- END: body -->
  	</tbody>
	</table>
<br>
<!-- END: disease -->
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=usg-process";

  function confirm_lower(index, vacid, petid) {
    var e = document.getElementById("vac_confirm_" + index);
    $.post(
      link,
      {action: "confirm", act: "down", value: trim(e.innerText), id: vacid},
      (data, status) => {
        data = JSON.parse(data);
        change_color(e, data, index, vacid, petid);
      }
    )
  }

  function confirm_upper(index, vacid, petid) {
    var e = document.getElementById("vac_confirm_" + index);
    $.post(
      link,
      {action: "confirm", act: "up", value: trim(e.innerText), id: vacid},
      (data, status) => {
        data = JSON.parse(data);
        change_color(e, data, index, vacid, petid);
      }
    )
  }

  function change_color(e, response, index, vacid, petid) {
    // console.log(e, response, index, vacid, petid);
    
    if (response["status"]) {
      e.innerText = response["data"]["value"];
      e.style.color = response["data"]["color"];
      if (response["data"]["color"] == "green" && response["data"]["recall"]) {
        e.parentElement.innerHTML += "<button id='recall_" + index + "' onclick='recall(" + index + ", " + vacid + ", " + petid + ", " + diseaseid + ")'>Tái chủng</button>";
      } else {
        $("#recall_" + index).remove();
      }
    }
  }

  $("#reman").click(() => {
    $("#vac_info").fadeOut();
    $("#reman").hide();
  })

  $("tbody td[class]").click((e) => {
    var data_collect = e.target.parentElement.children;
    var image = e.currentTarget.getAttribute("img");

    $("#vac_info").fadeIn();
    $("#reman").show();

    $("#petname").text(data_collect[1].innerText);
    $("#customer").text(data_collect[2].innerText);
    $("#phone").text(data_collect[3].innerText);
    $("#sieuam").text(data_collect[4].innerText);
    $("#dusinh").text(data_collect[5].innerText);
    // console.log(e);
    
    $("#thumb").attr("src", image);
  })

  function editNote(index) {
    var answer = prompt("Ghi chú: ", trim($("#note_v" + index).text()));
    if (answer) {
      $.post(
        link,
        {action: "editNote", note: answer, id: index},
        (data, status) => {
          data = JSON.parse(data);
          if(data["status"]) {
            $("#note_v" + index).text(answer);
          }
        }
      )
    }
  }

  function viewNote(index) {
    $("#note_" + index).toggle(500);
  }

</script>
<!-- END: main -->