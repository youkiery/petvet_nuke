<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}modules/{MODULE_NAME}/js/gallery/jquery.ad-gallery.css" />
<script src="{NV_BASE_SITEURL}modules/{MODULE_NAME}/js/gallery/jquery.ad-gallery.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    galleries[0].addAnimation('wild',
      function(img_container, direction, desc) {
        var current_left = parseInt(img_container.css('left'), 10);
        var current_top = parseInt(img_container.css('top'), 10);
        if(direction == 'left') {
          var old_image_left = '-'+ this.image_wrapper_width +'px';
          img_container.css('left',this.image_wrapper_width +'px');
          var old_image_top = '-'+ this.image_wrapper_height +'px';
          img_container.css('top', this.image_wrapper_height +'px');
        } else {
          var old_image_left = this.image_wrapper_width +'px';
          img_container.css('left','-'+ this.image_wrapper_width +'px');
          var old_image_top = this.image_wrapper_height +'px';
          img_container.css('top', '-'+ this.image_wrapper_height +'px');
        };
        if(desc) {
          desc.css('bottom', '-'+ desc[0].offsetHeight +'px');
          desc.animate({bottom: 0}, this.settings.animation_speed * 2);
        };
        img_container.css('opacity', 0);
        return {old_image: {left: old_image_left, top: old_image_top, opacity: 0},
                new_image: {left: current_left, top: current_top, opacity: 1},
                easing: 'easeInBounce',
                speed: 2500};
      }
    );
  });
</script>
<div style="padding:10px 0px; background:#F4F4F4;border:1px solid #EFEFEF">			
    <div class="ad-gallery">
      <div class="ad-image-wrapper"></div>
      <div class="ad-controls"></div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
            <!-- BEGIN: loop -->
            <li>
                <a href="{ROW.img}"><img src="{ROW.img_small}" title="{ROW.title}"/></a>
            </li>
            <!-- END: loop -->
          </ul>
        </div>
      </div>
    </div>
</div>
<!-- END: main -->