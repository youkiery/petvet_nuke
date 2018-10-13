<!-- BEGIN: main -->
<div class="articles_list">
	<ul>
    	<!-- BEGIN: loop -->
    	<li class="clearfix">
        	<!-- BEGIN: img --><a href="{ROW.link}"><img src="{ROW.src}" /></a><!-- END: img -->
            <span class="title"><a href="{ROW.link}">{ROW.title}</a></span>
            <p>{ROW.hometext}</p>
            <p align="right">
            	<span class="time">{LANG.update} : {ROW.add_time}</span>
                <a href="{ROW.link}"><span class="detail">{LANG.detail}</span></a>
                <!-- BEGIN: admin_link --><span>{admin_link}</span><!-- END: admin_link -->
            </p>
        </li>
        <!-- END: loop -->
    </ul>
    <!-- BEGIN: page -->
    <div class="articles_pages">{pages_html}</div>
    <!-- END: page -->
</div>
<!-- END: main -->