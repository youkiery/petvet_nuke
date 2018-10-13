<!-- BEGIN: main -->
	<!-- BEGIN: main1 -->
		<table class="tab1">
		    <caption>
		        {CAPTION}
		    </caption>
		    <thead>
		        <tr>
		            <td align="center"><img src="{NV_BASE_SITEURL}themes/{THEME}/images/system.png" /></td>
                    <td width="200">
		                {LANG.moduleName}
		            </td>
		            <td>
		                {LANG.moduleContent}
		            </td>
		            <td style="text-align:right">
		                {LANG.moduleValue}
		            </td>
		        </tr>
		    </thead>
			<!-- BEGIN: loop -->
		    <tbody {CLASS}>
		        <tr>
		            <td width="32" align="center"><img src="{NV_BASE_SITEURL}themes/{THEME}/images/system.png" /></td>
                    <td>
		                {MODULE}
		            </td>
		            <td>
		                {KEY}
		            </td>
		            <td style="text-align:right">
		                {VALUE}
		            </td>
		        </tr>
		    </tbody>
		    <!-- END: loop -->
		</table>
	<!-- END: main1 -->	
<!-- END: main -->