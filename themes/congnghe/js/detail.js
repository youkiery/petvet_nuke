(function(a){a.fn.imgScroll=function(b){return this.each(function(){var s=a.extend({evtType:"click",visible:1,showControl:true,showNavItem:false,navItemEvtType:"click",navItemCurrent:"current",showStatus:false,direction:"x",next:".next",prev:".prev",disableClass:"disabled",speed:300,loop:false,step:1},b);var i=a(this),k=i.find("ul"),o=k.find("li"),j=o.length,e=s.visible,d=s.step,g=parseInt((j-e)/d),r=0,m=i.css("position")=="absolute"?"absolute":"relative",p=o.css("float")!=="none",h=a('<div class="scroll-nav-wrap"></div>'),c=s.direction=="x"?"left":"top",n=s.direction=="x"?"width":"height";function q(){if(!p){o.css("float","left")}k.css({position:"absolute",left:0,top:0});i.css({position:m,width:s.direction=="x"?e*o.width():o.width(),height:s.direction=="x"?o.height():e*o.height(),overflow:"hidden"});a(s.prev).addClass(s.disableClass);if(s.loop){}else{if((j-e)%d!==0&&j>e){var v=d-(j-e)%d;k.append(o.slice(0,v).clone());j=k.find("li").length;g=parseInt((j-e)/d)}}k.css(n,j*o.width());if(!s.showControl&&j<=e){a(s.next+","+s.prev).hide()}if(j<=e){a(s.next+","+s.next).addClass(s.disableClass)}else{a(s.prev).addClass(s.disableClass);a(s.next).removeClass(s.disableClass)}if(s.showNavItem){for(var t=0;t<=g;t++){var u=t==0?s.navItemCurrent:"";h.append('<em class="'+u+'">'+(t+1)+"</em>")}i.after(h);h.find("em").bind(s.navItemEvtType,function(){var w=parseInt(this.innerHTML);l((w-1)*d)})}if(s.showStatus){i.after('<span class="scroll-status">'+1+"/"+(g+1)+"</span>")}}function l(t){if(k.is(":animated")){return false}if(t<0){a(s.prev).addClass(s.disableClass);return false}if(t+e>j){a(s.next).addClass(s.disableClass);return false}r=t;k.animate(s.direction=="x"?{left:-((t)*o.width())}:{top:-((r)*o.height())},s.speed,function(){if(t>0){a(s.prev).removeClass(s.disableClass)}else{a(s.prev).addClass(s.disableClass)}if(t+e<j){a(s.next).removeClass(s.disableClass)}else{a(s.next).addClass(s.disableClass)}f(t)})}function f(t){h.find("em").removeClass(s.navItemCurrent).eq(t/d).addClass(s.navItemCurrent);if(s.showStatus){a(".scroll-status").html(((t/d)+1)+"/"+(g+1))}}q();if(j>e){a(s.next).click(function(){l(r+d)});a(s.prev).click(function(){l(r-d)})}})}}(jQuery));
function MouseEvent(a) {
  this.x = a.pageX;
  this.y = a.pageY
}
(function(a) {
  a.fn.jqueryzoom = function(c) {
    var b = {xzoom:200, yzoom:200, offset:10, position:"right", lens:1, preload:1};
    c && a.extend(b, c);
    var d = "";
    a(this).hover(function() {
      var c = a(this).offset().left, f = a(this).offset().top, g = a(this).find("img").get(0).offsetWidth, i = a(this).find("img").get(0).offsetHeight;
      d = a(this).find("img").attr("alt");
      var h = a(this).find("img").attr("jqimg");
      a(this).find("img").attr("alt", "");
      0 == a("div.zoomdiv").get().length && (a(this).after("<div class='zoomdiv'><img class='bigimg' src='" + h + "'/></div>"), a(this).append("<div class='jqZoomPup'>&nbsp;</div>"));
      a("div.zoomdiv").width(b.xzoom);
      a("div.zoomdiv").height(b.yzoom);
      a("div.zoomdiv").show();
      b.lens || a(this).css("cursor", "crosshair");
      a(document.body).mousemove(function(d) {
        mouse = new MouseEvent(d);
        var d = a(".bigimg").get(0).offsetWidth, h = a(".bigimg").get(0).offsetHeight, l = "x", j = "y";
        isNaN(j) | isNaN(l) && (j = d / g, l = h / i, a("div.jqZoomPup").width(b.xzoom / (1 * j)), a("div.jqZoomPup").height(b.yzoom / (1 * l)), b.lens && a("div.jqZoomPup").css("visibility", "visible"));
        xpos = mouse.x - a("div.jqZoomPup").width() / 2 - c;
        ypos = mouse.y - a("div.jqZoomPup").height() / 2 - f;
        b.lens && (xpos = mouse.x - a("div.jqZoomPup").width() / 2 < c ? 0 : mouse.x + a("div.jqZoomPup").width() / 2 > g + c ? g - a("div.jqZoomPup").width() - 2 : xpos, ypos = mouse.y - a("div.jqZoomPup").height() / 2 < f ? 0 : mouse.y + a("div.jqZoomPup").height() / 2 > i + f ? i - a("div.jqZoomPup").height() - 2 : ypos);
        b.lens && a("div.jqZoomPup").css({top:ypos, left:xpos});
        scrolly = ypos;
        a("div.zoomdiv").get(0).scrollTop = scrolly * l;
        scrollx = xpos;
        a("div.zoomdiv").get(0).scrollLeft = scrollx * j
      })
    }, function() {
      a(this).children("img").attr("alt", d);
      a(document.body).unbind("mousemove");
      b.lens && a("div.jqZoomPup").remove();
      a("div.zoomdiv").remove()
    });
    count = 0;
    b.preload && (a("body").append("<div style='display:none;' class='jqPreload" + count + "'>360buy</div>"), a(this).each(function() {
      var b = a(this).children("img").attr("jqimg"), c = jQuery("div.jqPreload" + count + "").html();
      jQuery("div.jqPreload" + count + "").html(c + '<img src="' + b + '">')
    }))
  }
})(jQuery);
$(function() {
  $(".jqzoom").jqueryzoom({xzoom:400, yzoom:400, offset:10, position:"left", preload:1, lens:1});
  $("#summary-grade .dd").click(function() {
    var a = $("#comment");
    "true" !== $("#comment").attr("nodata") ? a.show() : $(document).scrollTop($("#comments-list").offset().top + $("#comments-list .mt").height())
  });
  $("#spec-list img").mouseover(function() {
    var a = $(this).attr("src");
    $("#spec-list img").removeClass("img-hover");
    $(this).addClass("img-hover");
    $("#spec-n1 img").eq(0).attr({src:a.replace("/n5/", "/n1/"), jqimg:a.replace("/n5/", "/n0/")})
  });
  $(".spec-items").imgScroll({visible:5, speed:200, step:1, loop:!1, prev:"#spec-forward", next:"#spec-backward", disableClass:"disabled"});
});
var setAmount = {min:1, max:999, data:{pid:pageConfig.product.skuid, pcount:$("#buy-num").val(), ptype:1}, reg:function(a) {
  return/^[1-9]\d*$/.test(a)
}, amount:function(a, c) {
  var b = $(a).val();
  this.reg(b) ? c ? b++ : b-- : (alert("?"), $(a).val(1), $(a).focus());
  return b
}, reduce:function(a) {
  var c = this.amount(a, !1);
  c >= this.min ? $(a).val(c) : (alert("Số sản phẩm không được ít hơn " + this.min), $(a).val(1), $(a).focus());
  this.data.pcount && (this.data.pcount = $("#buy-num").val());
}, add:function(a) {
  var c = this.amount(a, !0);
  c <= this.max ? $(a).val(c) : (alert("Số sản phẩm không được nhiều hơn " + this.max), $(a).val(999), $(a).focus());
  this.data.pcount && (this.data.pcount = $("#buy-num").val());
}, modify:function(a) {
  var c = $(a).val();
  if(c < this.min || c > this.max || !this.reg(c)) {
    alert("Xin vui lòng nhập số lượng từ 1 - 999"), $(a).val(1), $(a).focus()
  }
  this.data.pcount && (this.data.pcount = $("#buy-num").val());
}};
