<!-- BEGIN: main -->
<div id="products">
	<!-- BEGIN: catalogs -->
	<div class="title-content">
		<p class="mang">
			<a href="{LINK_CATALOG}" title="{TITLE_CATALOG}">{TITLE_CATALOG}</a>
		</p>
		<div class="tab-items-i"></div>
	</div>
	<section class="group-index-pro">
		<aside class="col-mid-i">
			<ul class="items-p-i" id="thumb">
				<!-- BEGIN: items -->
				<li id="tip_1422" class="vnit_tip">
					<div class="img" align="center">
						<a title="{TITLE}" href="{LINK}"> <img height="120" src="{IMG_SRC}" id="zoom" alt="{TITLE}"> </a>
					</div>
					<p class="name">
						<a title="{TITLE}" href="{LINK}">{TITLE0}</a>
					</p>
					<!-- BEGIN: price -->
					<div class="sales-off">
						<p class="{class_money}">
							<span>{product_price} {money_unit}</span>
						</p>
						<!-- BEGIN: discounts -->
						<p class="discount">
							{LANG.deal_savings}: {product_price_end} {money_unit}
						</p>
						<p class="price">
							<span>{product_discounts} {money_unit}</span>
						</p>
						<!-- END: discounts -->
					</div>
					<!-- END: price -->
					<!-- BEGIN: contact -->
					<p class="price">
						<span>{LANG.detail_pro_price}: </span><strong>{LANG.price_contact}</strong>
					</p>
					<!-- END: contact -->
					<!-- BEGIN: tooltip -->
					<div id="vtip">
						<div class="v-title">
							<p>
								{TITLE0}
							</p>
						</div>
						<div class="vcontent">
							{hometext}
						</div>
					</div>
					<!-- END: tooltip -->
				</li>
				<!-- END: items -->
			</ul>
		</aside>
	
	</section>
	<!-- END: catalogs -->
</div>
<div class="msgshow" id="msgshow"></div>
<!-- BEGIN: tooltip_js -->
<script type="text/javascript">
	tooltip_shop();

</script>
<!-- END: tooltip_js -->
<!-- END: main -->
