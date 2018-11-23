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

  <button class="button" style="position: absolute; bottom: 26px; left: 10px;" onclick="ketthuc(1)">
    {lang.trihet}
  </button>
  <button class="button" style="position: absolute; bottom: 26px; left: 110px;" onclick="ketthuc(2)">
    {lang.dachet}
  </button>
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
    $("#luubenh").text(data_collect[5].innerText);
    var h_lieutrinh = "<form onSubmit='return save(event)'><div class='khung'>";
    var lieutrinh = trim(data_collect[8].innerText);
    if (lieutrinh) {
      var lieutrinh = JSON.parse(lieutrinh);
      var option_type = ["Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết"];
      lieutrinh.forEach((row, index) => {
        var h_option = ""
        option_type.forEach((option, index) => {
          checked = ""
          // console.log(row["tinhtrang"], index);
          if (row["tinhtrang"] == index) {
            checked = "selected"
            // console.log("x");
          }
          h_option += "<option value='" + index + "' " + checked + ">" + option + "</option>";
          // console.log(h_option);
        })
        h_lieutrinh += "<span><b>" + row["ngay"] + "" + "</b></span> <select name='tinhtrang["+index+"]' id='tinhtrang'>" + h_option + "</select> <div><input class='input' type='text' name='lieutrinh[" + index + "]' value='" + row["ghichu"] + "'></div>";
      })
    }
    h_lieutrinh += `</div><div style="text-align: center;"><button class="button"> {lang.submit} </button></div><form>`;
    $("#lieutrinh").html(h_lieutrinh);
    $("#thumb").attr("src", image);
    lid = e.currentTarget.getAttribute("id");
  })

  function ketthuc(val) {
    $.post(
      link + "luubenh",
      {action: "trihet", id: lid, val: val},
      (response, status) => {
        // console.log(response);
        response = JSON.parse(response);
        if (response["status"]) {
          $("#vac_info").fadeOut();
          $("#reman").hide();
        }
      }
    )    
  }

  function save(e) {
    e.preventDefault();
    var lieutrinh = $("[name^=lieutrinh]");
    var tinhtrang = $("[name^=tinhtrang]");
    var vlieutrinh = []
    lieutrinh.each((i, j) => {
      console.log(tinhtrang[i]);
      
      vlieutrinh[i] = tinhtrang[i].value + ":" + j.value
    })    

    $.post(
      link + "luubenh",
      {action: "luulieutrinh", id: lid, lieutrinh: vlieutrinh.join("|")},
      (response, status) => {
        // console.log(response);
        response = JSON.parse(response);
        if (response["status"]) {
          $("#" + lid + " .lieutrinh").text(response["data"]);
        }
      }
    )    
  }
</script>
<!-- END: main -->