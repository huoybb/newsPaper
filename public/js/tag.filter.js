(function() {
  $(function() {
    $('#search').keyup(function() {
      var key;
      key = $.trim($(this).val()).toUpperCase().replace(/\s+/g, "|");
      return $('a.btn').hide().filter(function() {
        var keywords;
        keywords = $(this).text().toUpperCase();
        return keywords.match(key);
      }).show();
    });
    return $("#search").trigger("keyup");
  });

}).call(this);
