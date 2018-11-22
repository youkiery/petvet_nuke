<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>

<div id="vac_notify"></div>
<div id="reman"></div>
<div id="vac_info" style="display:none;">
  <div id="info">
    <p>
      {lang.petname}: 
      <span id="petname"></span>
    </p>
    <p>
      {lang.customer}: 
      <span id="customer"></span>
    </p>
    <p>
      {lang.phone}: 
      <span id="phone"></span>
    </p>
    <p>
      {lang.ngayluubenh}: 
      <span id="luubenh"></span>
    </p>
  </div>
  <div id="lieutrinh">

  </div>
</div>
<form class="vac_form" method="GET">
  <input type="hidden" name="nv" value="vac">
  <input type="hidden" name="op" value="danhsachsieuam">
  <input type="text" name="key" value="{keyword}" class="vac_input">
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<div id="disease_display">
  {content}
</div>
<script>
  var link = "/index.php?" + nv_name_variable + "=" + nv_module_name + "&act=post&" + nv_fc_variable + "=";
  var lid = -1;
  $("#reman").click(() => {
    $("#vac_info").fadeOut();
    $("#reman").hide();
  })

  $("tbody tr").click((e) => {
    var data_collect = e.currentTarget.children;
    var image = e.currentTarget.getAttribute("img");

    $("#vac_info").fadeIn();
    $("#reman").show();

    $("#petname").text(data_collect[1].innerText);
    $("#customer").text(data_collect[2].innerText);
    $("#phone").text(data_collect[3].innerText);
    $("#luubenh").text(data_collect[4].innerText);
    var h_lieutrinh = "<form onSubmit='return save(event)'><div class='khung'>";
    var lieutrinh = trim(data_collect[5].innerText);
    if (lieutrinh) {
      var lieutrinh = JSON.parse(lieutrinh);
      lieutrinh.forEach((row, index) => {
        h_lieutrinh += "<p><b>" + row["ngay"] + "" + "</b></p><div><input class='input' type='text' name='lieutrinh[" + index + "]' value='" + row["ghichu"] + "'></div>";
      })
    }
    h_lieutrinh += `</div><div style="text-align: center;"><button class="button"> {lang.submit} </button></div><form>`;
    $("#lieutrinh").html(h_lieutrinh);
    $("#thumb").attr("src", image);
    lid = e.currentTarget.getAttribute("id");
  })
  function save(e) {
    e.preventDefault();
    var lieutrinh = $("[name^=lieutrinh]");
    var vlieutrinh = []
    lieutrinh.each((i, j) => {
      vlieutrinh[i] = j.value
    })    

    $.post(
      link + "luubenh",
      {action: "luulieutrinh", id: lid, lieutrinh: vlieutrinh.join("|")},
      (response, status) => {
        // console.log(response);
        response = JSON.parse(response);
        if (response["status"]) {
          var x = $("#" + lid + " .lieutrinh");
          // console.log(x.text());
          
          x.text(response["data"]);
          lid = -1;
        }
      }
    )    
  }
</script>
<!-- END: main -->