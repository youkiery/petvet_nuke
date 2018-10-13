<!-- BEGIN: main -->
<div class="articles_gird">
    <div class="clearfix">	
        <!-- BEGIN: loop -->
    	<div class="clearfix items" style="width:{ROW.widthview}%">
        	<div class="items_content">
                <!-- BEGIN: img --><a href="{ROW.link}"><img src="{ROW.src}" /></a><!-- END: img -->
                <span class="title"><a href="{ROW.link}">{ROW.title}</a></span>
                <p align="justify">{ROW.hometext}</p>
                <span class="time">{LANG.update} : {ROW.add_time}</span>
                <p align="right">
                    <a href="{ROW.link}"><span class="detail">{LANG.detail}</span></a>
                    <!-- BEGIN: admin_link --><span>{admin_link}</span><!-- END: admin_link -->
                </p>
            </div>
        </div>
        <!-- END: loop -->
    </div>
    <!-- BEGIN: page -->
    <div class="articles_pages">{pages_html}</div>
    <!-- END: page -->
</div>
<!-- END: main -->