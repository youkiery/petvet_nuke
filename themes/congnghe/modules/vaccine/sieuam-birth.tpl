<!-- BEGIN: main -->
<div id="msgshow" class="msgshow"></div>
<div id="vac_notify"></div>
<form class="vac_form" method="GET">
  <input type="hidden" name="nv" value="{nv}">
  <input type="hidden" name="op" value="{op}">
  <input type="text" name="key" value="{keyword}" class="vac_input">
  <select name="limit">
    <!-- BEGIN: limit -->
    <option value="{limitvalue}" {lcheck}>{limitname}</option>
    <!-- END: limit -->
  </select>
  <input type="submit" class="vac_button" value="{lang.search}">
</form>
<table class="vng_vacbox tab1">
  <thead>
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
        {lang.doctor}
      </th>  
      <th>
        {lang.usgbirthday}
      </th>  
      <th>
        {lang.usgbirth}
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
      <td class="nphone">
        {doctor}
      </td>    
      <td class="sieuam">
        {birthday}
      </td>    
      <td class="dusinh">
        {birth}
      </td>
    </tr>
  <!-- END: list -->
    <tr>
      <td colspan="7">
        <p style="float: right;">
          {nav}
        </p>
      </td>
    </tr>
  </tbody>
</table>
<!-- END: main -->