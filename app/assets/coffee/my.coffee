#class pageMove
#  constructor:(el)->
#    @el = $(el)
#    @el.mouseover =>
#      @openhand()
#    .mousedown (e)=>
#      e.preventDefault()
#      @closehand()
#      start = {X:e.pageX,Y:e.pageY}
#      @el.mouseover (e)=>
#        Y = @getNewY(e,start)
#        @el.scrollTop(Y)
#    .mouseup =>
#      @openhand().unbindMove()
#    .mouseover =>
#      @openhand().unbindMove()
#
#  openhand: ->
#    @el.css("cursor","url(http://dn382/ZF1.5/images/openhand.cur), default")
#    @
#  closehand: ->
#    @el.css("cursor","url(http://dn382/ZF1.5/images/closedhand.cur), default")
#    @
#  getNewY:(e,start)->
#    end={X:e.pageX,Y:e.pageY}
#    delta={xx:end.X-start.X,yy:end.Y-start.Y}
#    yy=@el.scrollTop()
#    yy-delta.yy
#    start.X=end.X;start.Y=end.Y
#  unbindMove:->
#    @el.unbind 'mousemove'
#    @


$ ->
  # 前后导航键的设置，方便浏览
  if $('.next a').length
    key 'right',->
      location.href = $('.next a').attr('href')
  if $('.prev a').length
    key 'left',->
      location.href = $('.prev a').attr('href')
#  new pageMove('body')
  $('body')
  .mouseover ->
    $(this).css("cursor","url(http://dn382/ZF1.5/images/openhand.cur), default")
  .mousedown (e)->
    e.preventDefault()
    $(this).css("cursor","url(http://dn382/ZF1.5/images/closedhand.cur), default")
    start = {X:e.pageX,Y:e.pageY}
    $(this).mousemove (e)->
      end={X:e.pageX,Y:e.pageY}
      delta={xx:end.X-start.X,yy:end.Y-start.Y}
      yy = $(this).scrollTop()
      xx = $(this).scrollLeft()
      Y = yy-delta.yy
      X = xx-delta.xx
      start.X=end.X;start.Y=end.Y
      $(this).scrollTop(Y)
      $(this).scrollLeft(X)
  .mouseup (e)->
    $(this).css("cursor","url(http://dn382/ZF1.5/images/openhand.cur), default")
    $(this).unbind("mousemove")
  .mouseover (e)->
    $(this).unbind('mousemove')



