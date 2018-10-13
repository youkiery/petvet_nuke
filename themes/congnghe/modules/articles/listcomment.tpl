<!-- BEGIN: main -->
<div class="articles_commment_list">
	<h3>{LANG.comment_title} : </h3>
	<ul>
    	<!-- BEGIN: loop -->
    	<li>
        	<strong>{ROW.post_name}</strong> <span class="time">({ROW.post_time})</span>
            <br /><span class="time">{ROW.post_email}</span>
            <p>{ROW.content}</p>
        </li>
        <!-- END: loop -->
    </ul>
    <!-- BEGIN: page -->
    <div class="articles_pages">{pages_html}</div>
    <!-- END: page -->
</div>
<!-- END: main -->