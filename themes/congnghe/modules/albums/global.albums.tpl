

<!-- BEGIN: main -->
    <link media="screen" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet">
    	<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
            	<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/site_code/fancybox/jquery.mousewheel-3.0.4.pack.js" type="text/javascript"></script>
                <script>
   jQuery(document).ready(function(){
   jQuery("a[rel=group_image]").fancybox({
   'transitionIn'		: 'none',
   'transitionOut'		: 'none',
   'titlePosition' 	: 'over',
   'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
   return '' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &amp;nbsp; ' + title : '') + '';
   }
   });	
   });
</script>

<div class="home-bottom">
                        <div class="strands-container">
                           <b class="styledHR"><i></i></b>
<div  class="strandsRecs youMightAlsoLike" >
   <style type="text/css">.SBSHOME-1Background a {border:0;text-decoration:none}
      .SBSHOME-1Background {width:945px;border:0px solid #ffffff;background-color:transparent}
      .SBSHOME-1HeaderWrap {width:945px;overflow:hidden}
      .SBSHOME-1HeaderText {font-family:Trebuchet MS;font-size:12px;color:#000000;font-weight:normal;text-align:left;background-color:transparent;display:block;padding:3px 4px 3px 4px}
      table.SBSHOME-1Items {width:100%; table-layout:fixed}
      table.SBSHOME-1Items td,table.SBSHOME-1Items tr {padding:0;margin:0}
      table.SBSHOME-1Items tr {vertical-align:top}
      .SBSHOME-1recframe {text-align:left;width:135px;overflow:hidden}
      .SBSHOME-1recinner {padding:5px}
      table.SBSHOME-1Items tr.SBSHOME-1Himg td {vertical-align:bottom}.SBSHOME-1img {margin:5px 0}
      .SBSHOME-1img img {width:130px;height:auto;display:inline}
      .SBSHOME-1Strands {clear:both;padding:0 5px;text-align:center;background-color:transparent}
      .SBSHOME-1Clear {clear:both;line-height:0px;height:0px;margin=0;paddding:0}
      .SBSHOME-1norecs {height:50px}
   </style>
   <div style="margin: 10px auto 0;" class="SBSHOME-1Background">
      <div class="SBSHOME-1HeaderWrap">
         <div class="SBSHOME-1HeaderText">
            <h2 class="trending-title">Albums Now</h2>
            <h6 class="trending-message">Khai Trương showroom mới.</h6>
         </div>
      </div>
      <table cellspacing="0" cellpadding="0" class="SBSHOME-1Items">
         <tbody>
            <tr>
            <!-- BEGIN: loop -->
               <td class="SBSHOME-1recframe">
                  <div class="SBSHOME-1recinner">
                     <div class="SBSHOME-1img"><a rel="group_image"  href="{ROW.img_small}"><img border="0" src="{ROW.img_small}"></a></div>
                  </div>
               </td>
            <!-- END: loop -->   
               

            </tr>
         </tbody>
      </table>
      <div class="SBSHOME-1Clear"></div>
   </div>
</div>


                           <b class="styledHR"><i></i></b>
                        </div>
                     </div>
<!-- END: main -->