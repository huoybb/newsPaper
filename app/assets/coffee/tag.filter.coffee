$ ->
  $('#search').keyup ->
    key = $.trim($(this).val()).toUpperCase().replace /\s+/g,"|"
    $('a.btn')
    .hide()
    .filter ->
  #    keywords = $(this).text().toUpperCase()+' '+$('a',this).data('keywords').toUpperCase()
      keywords = $(this).text().toUpperCase()
      keywords.match(key)
    .show()

  #  第一次的时候，先进行一下搜索过滤
  $("#search").trigger("keyup")
