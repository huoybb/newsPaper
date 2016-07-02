(function() {
  $(function() {
    var Y, match, myregexp;
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
    $('.setFocusAction').click(function(e) {
      vex.dialog.open({
        message: '请输入新闻标题',
        input: "<input name=\"title\" type=\"text\" placeholder=\"新闻标题\" required />\n<textarea name=\"description\" placeholder=\"描述\" rows='3' required />\n<input name=\"tags\" type=\"text\" placeholder=\"标签分类，以空格分开\" required />\n",
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
    $('.addTag').click(function(e) {
      vex.dialog.open({
        message: '请输入标签名称',
        input: "<input name=\"tag\" type=\"text\" placeholder=\"标签名称\" required />",
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
          url = location.href;
          url += '/addTag';
          return $.post(url, data, function(result) {
            console.log(result);
            if (result === 'sucess') {
              return location.reload();
            }
          });
        }
      });
      return e.preventDefault();
    });
    myregexp = /http:\/\/newspaper[\s\S]zhaobing\/issues\/[0-9]+\/page\/[0-9]+\?Y=([0-9]+)/m;
    match = myregexp.exec(location.href);
    if (match !== null) {
      Y = match[1];
      console.log(Y);
      return $('body').scrollTop(Y);
    }
  });

}).call(this);
