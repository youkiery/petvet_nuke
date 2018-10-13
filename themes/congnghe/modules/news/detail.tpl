<!-- BEGIN: main -->

<div class="ct_left">
            
            <div class="dttc_td" style="text-transform:uppercase"></div>
   	
                        	<div class="dt_ndung">
                            	<h3>
                                  {DETAIL.title}
                            	</h3>
                                <div style="margin:0 0px 10px 0; width:100%; float:left"> 
                            
                            <div class="addthis_toolbox addthis_default_style" style="float:right">
                         
                         <span class="small">{LANG.pubtime}: {DETAIL.publtime} 
                         <!-- BEGIN: post_name --> 
            
            - {LANG.post_name}: <a class="highlight" href="#">{DETAIL.post_name}</a>
            <!-- END: post_name -->
            
            </span>  
                            <div class="atclear">
       </div></div>
  </div>
               <div id="bodytext" class="details-content clearfix">
        {DETAIL.bodytext}
    </div>
                                
              
                            
                            


<!-- BEGIN: related_new -->
                            <div class="dt_cttk">
                            	<div class="dt_font16 dtctlq_td">{LANG.related_new}</div>
                             	<ul class="l_cttk">
                                 <!-- BEGIN: loop -->
                              		<li class="l_cttk"><a href="{RELATED_NEW.link}" title="{RELATED_NEW.title}">{RELATED_NEW.title}</a> <span class="date">({RELATED_NEW.time})</span>
                                    </li>
                               
                              <!-- END: loop -->	
                                
                           		</ul>
                            </div>  
                            
               <!-- END: related_new -->              
          </div>                  
                                     
                 
&nbsp;
                </div>
<!-- END: main -->

<!-- BEGIN: no_permission -->
    <div id="no_permission">
        <p>
            {NO_PERMISSION}
        </p>
    </div>
<!-- END: no_permission -->