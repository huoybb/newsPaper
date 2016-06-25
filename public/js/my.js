(function() {
  $(function() {
    if ($('.next a').length) {
      key('right', function() {
        return location.href = $('.next a').attr('href');
      });
    }
    if ($('.prev a').length) {
      key('left', function() {
        return location.href = $('.prev a').attr('href');
      });
    }
    return $('body').mouseover(function() {
      return $(this).css("cursor", "url(http://dn382/ZF1.5/images/openhand.cur), default");
    }).mousedown(function(e) {
      var start;
      e.preventDefault();
      $(this).css("cursor", "url(http://dn382/ZF1.5/images/closedhand.cur), default");
      start = {
        X: e.pageX,
        Y: e.pageY
      };
      return $(this).mousemove(function(e) {
        var Y, delta, end, yy;
        end = {
          X: e.pageX,
          Y: e.pageY
        };
        delta = {
          xx: end.X - start.X,
          yy: end.Y - start.Y
        };
        yy = $(this).scrollTop();
        Y = yy - delta.yy;
        start.X = end.X;
        start.Y = end.Y;
        return $(this).scrollTop(Y);
      });
    }).mouseup(function(e) {
      $(this).css("cursor", "url(http://dn382/ZF1.5/images/openhand.cur), default");
      return $(this).unbind("mousemove");
    }).mouseover(function(e) {
      return $(this).unbind('mousemove');
    });
  });

}).call(this);
