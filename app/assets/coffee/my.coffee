$ ->
  # 前后导航键的设置，方便浏览
  if $('.next a').length
    key 'right',->
      location.href = $('.next a').attr('href')
  if $('.prev a').length
    key 'left',->
      location.href = $('.prev a').attr('href')
#  $('.box')
#  .mouseover ->
#    $(this).css("cursor","url(http://dn382/ZF1.5/images/openhand.cur), default")
#  .mousedown (e)->
#    e.preventDefault()
#    $(this).css("cursor","url(http://dn382/ZF1.5/images/closehand.cur), default")
#    start = {X:e.pageX,Y:e.pageY}
#    $(this).mousemove (e)->
#      $(this).text()
