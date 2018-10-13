<!-- BEGIN: main -->
<div id="group">
<!-- BEGIN: loop -->
<div class="deal">
	<div class="p-img">
		<a href="{link}" title="{title}"><img src="{src_img}" width="100" height="100" alt="{title}" /></a>
	</div>
	<div class="p-name">
		<a href="{link}" title="{title}">{title}</a>
		<p>
			{hometext}
		</p>
	</div>
	<!-- BEGIN: price -->
	<div class="p-market">
		{title_price}:<del>&nbsp;{product_price} {money_unit}</del>
	</div>
	<!-- END: price -->
	<span class="clr"></span>
	<div class="p-detail">
		<a href="{link}" title="{detail_product}" class="btn-tuan" >{detail_product}</a><!-- BEGIN: discounts --><span>{title_price}:</span><strong>&nbsp;{product_discounts} {money_unit}</strong><!-- END: discounts -->
	</div>
</div>
<!-- END: loop -->
</div>
<!-- END: main -->