(function(jq) {
    jq.autoScroll = function(ops) {
        ops = ops || {};
        ops.styleClass = ops.styleClass || 'scroll-to-top-button';
        var t = jq('<div class="'+ops.styleClass+'"></div>'),
            d = jq(ops.target || document);
        jq(ops.container || 'body').append(t);

        t.css({
            opacity: 0,
            position: 'absolute',
            top: 0,
            right: 0
        }).click(function() {
            jq('html,body').animate({
                scrollTop: 0
            }, ops.scrollDuration || 1000);
        });

        d.scroll(function() {
            var sv = d.scrollTop();
            if (sv < 10) {
                t.clearQueue().fadeOut(ops.hideDuration || 200);
                return;
            }

            t.css('display', '').clearQueue().animate({
                top: sv,
                opacity: 0.8
            }, ops.showDuration || 500);
        });
    };
})(jQuery);