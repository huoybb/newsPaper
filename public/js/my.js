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
    $('body').mouseover(function() {
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
        var X, Y, delta, end, xx, yy;
        end = {
          X: e.pageX,
          Y: e.pageY
        };
        delta = {
          xx: end.X - start.X,
          yy: end.Y - start.Y
        };
        yy = $(this).scrollTop();
        xx = $(this).scrollLeft();
        Y = yy - delta.yy;
        X = xx - delta.xx;
        start.X = end.X;
        start.Y = end.Y;
        $(this).scrollTop(Y);
        return $(this).scrollLeft(X);
      });
    }).mouseup(function(e) {
      $(this).css("cursor", "url(http://dn382/ZF1.5/images/openhand.cur), default");
      return $(this).unbind("mousemove");
    }).mouseover(function(e) {
      return $(this).unbind('mousemove');
    });
    return $('.setFocusAction').click(function(e) {
      vex.dialog.open({
        message: '请输入新闻标题',
        input: "<input name=\"title\" type=\"text\" placeholder=\"新闻标题\" required />\n<textarea name=\"description\" placeholder=\"描述\" rows='3' required />",
        buttons: [
          $.extend({}, vex.dialog.buttons.YES, {
            text: '确定'
          }), $.extend({}, vex.dialog.buttons.NO, {
            text: '取消'
          })
        ],
        callback: function(data) {
          var url;
          if (data === false) {
            return console.log('Cancelled');
          }
          data.Y = $(document).scrollTop();
          data.url = location.href;
          url = '/focus/add';
          return $.post(url, data);
        }
      });
      return e.preventDefault();
    });
  });

}).call(this);
