(function() {
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

}).call(this);
