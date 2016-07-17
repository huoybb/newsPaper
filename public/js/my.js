(function() {
  var changImgSize;

  $(function() {
    if ($('.next a').length) {
      key('right', function() {
        return location.href = $('.next a').attr('href');
      });
    }
    if ($('.prev a').length) {
      return key('left', function() {
        return location.href = $('.prev a').attr('href');
      });
    }
  });

  $(function() {
    return $('.setFocusAction').click(function(e) {
      vex.dialog.open({
        message: '请输入新闻标题',
        input: "<input name=\"title\" type=\"text\" placeholder=\"新闻标题\" required />\n<textarea name=\"description\" placeholder=\"描述\" rows='3' optional />\n<input name=\"tags\" type=\"text\" placeholder=\"标签分类，以空格分开\" required />\n",
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

  $(function() {
    return $('.addTag').click(function(e) {
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
          $.post(url, data);
          return setTimeout('location.reload();', 500);
        }
      });
      return e.preventDefault();
    });
  });

  $(function() {
    return $('.addComment').click(function(e) {
      vex.dialog.open({
        message: '请输入评论的内容',
        input: "<textarea name=\"content\" placeholder=\"评论内容\" rows='3' required />",
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
          url += '/addComment';
          $.post(url, data);
          return setTimeout('location.reload();', 500);
        }
      });
      return e.preventDefault();
    });
  });

  $(function() {
    return $('.showFocus').click(function(e) {
      return e.preventDefault();
    });
  });

  $(function() {
    var Y, match, myregexp;
    myregexp = /\/issues\/[0-9]+\/page\/[0-9A-Z]+\?Y=([0-9]+)/m;
    match = myregexp.exec(location.href);
    if (match !== null) {
      Y = match[1];
      console.log(Y);
      return $('body').scrollTop(Y);
    }
  });

  changImgSize = function(img, width_img) {
    var shift, width_max, width_standard;
    width_standard = $('.myContainer .row').width();
    width_max = $(window).width() - 10;
    if (width_img > width_max) {
      img.width(width_max);
      shift = (width_max - width_standard) / 2;
    }
    if ((width_max > width_img && width_img > width_standard)) {
      shift = (width_img - width_standard) / 2;
    }
    if (width_standard > width_img) {
      shift = 0;
    }
    return img.css('margin-left', -shift);
  };

  $(window).load(function() {
    var img, width_img;
    img = $('img');
    width_img = img.width();
    changImgSize(img, width_img);
    return window.onresize = function() {
      return changImgSize(img, width_img);
    };
  });

  $(function() {
    return $("#search-form").submit(function(e) {
      var keywords;
      keywords = $("#search").val().trim();
      keywords = keywords.replace(/\//, ' ');
      if (keywords !== '') {
        location.href = "http://" + location.host + ("/search/" + keywords);
      }
      return e.preventDefault();
    });
  });

}).call(this);
