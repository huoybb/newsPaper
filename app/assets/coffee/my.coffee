$ ->
  # 前后导航键的设置，方便浏览
  if $('.next a').length
    key 'right',->
      location.href = $('.next a').attr('href')
  if $('.prev a').length
    key 'left',->
      location.href = $('.prev a').attr('href')
#  设置鼠标拖动图片的功能，这个在pad或者没有鼠标时有用
#  $('body')
#  .mouseover ->
#    $(this).css("cursor","url(http://dn382/ZF1.5/images/openhand.cur), default")
#  .mousedown (e)->
#    e.preventDefault()
#    $(this).css("cursor","url(http://dn382/ZF1.5/images/closedhand.cur), default")
#    start = {X:e.pageX,Y:e.pageY}
#    $(this).mousemove (e)->
#      end={X:e.pageX,Y:e.pageY}
#      delta={xx:end.X-start.X,yy:end.Y-start.Y}
#      yy = $(this).scrollTop()
#      xx = $(this).scrollLeft()
#      Y = yy-delta.yy
#      X = xx-delta.xx
#      start.X=end.X;start.Y=end.Y
#      $(this).scrollTop(Y)
#      $(this).scrollLeft(X)
#  .mouseup (e)->
#    $(this).css("cursor","url(http://dn382/ZF1.5/images/openhand.cur), default")
#    $(this).unbind("mousemove")
#  .mouseover (e)->
#    $(this).unbind('mousemove')

  #  设置新闻关注
$ ->
  $('.setFocusAction').click (e)->
    vex.dialog.open
#      appendLocation: '.myContainer'
      message: '请输入新闻标题'
      input: """
          <input name="title" type="text" placeholder="新闻标题" required />
          <textarea name="description" placeholder="描述" rows='3' required />
          <input name="tags" type="text" placeholder="标签分类，以空格分开" required />

        """
      buttons: [
        $.extend({}, vex.dialog.buttons.YES, text: '确定')
        $.extend({}, vex.dialog.buttons.NO, text: '取消')
      ]
      callback: (data) ->
        return console.log('Cancelled') if data is false
        data.Y = $(document).scrollTop()
        data.url = location.href
#        console.log data
        url = '/focus/add'
        $.post url,data
    e.preventDefault()
#    添加标签
$ ->
  $('.addTag').click (e)->
    vex.dialog.open
      message: '请输入标签名称'
      input: """
          <input name="tag" type="text" placeholder="标签名称" required />
      """
      buttons: [
        $.extend({}, vex.dialog.buttons.YES, text: '确定')
        $.extend({}, vex.dialog.buttons.NO, text: '取消')
      ]
      callback: (data) ->
        return console.log('Cancelled') if data is false
        url = location.href
        url += '/addTag'
        $.post url,data
        setTimeout('location.reload();',500)
    e.preventDefault()
#    添加评论
$ ->
  $('.addComment').click (e)->
    vex.dialog.open
      message: '请输入评论的内容'
      input: """
            <textarea name="content" placeholder="评论内容" rows='3' required />
      """
      buttons: [
        $.extend({}, vex.dialog.buttons.YES, text: '确定')
        $.extend({}, vex.dialog.buttons.NO, text: '取消')
      ]
      callback: (data) ->
        return console.log('Cancelled') if data is false
        url = location.href
        url += '/addComment'
        $.post url,data
        setTimeout('location.reload();',500)
    e.preventDefault()

#  设置偏移量 scrollY
$ ->
  myregexp = /http:\/\/newspaper[\s\S]zhaobing\/issues\/[0-9]+\/page\/[0-9]+\?Y=([0-9]+)/m
  match = myregexp.exec(location.href)
  if match isnt null
    Y = match[1]
    console.log Y 
    $('body').scrollTop Y

#  调整图片大小
$ ->
  img = $('img')
  if img.width() > 1386
    img.width(1486)
    img.css('margin-left',-100)

# 搜索功能键的设置
$ ->
  $("#search-form").submit (e)->
    keywords = $("#search").val().trim()
    keywords = keywords.replace(/\//,' ') #去除搜索中的"/"，避免出现路由错误
    location.href = "http://"+location.host+"/search/#{keywords}" if keywords isnt ''
    e.preventDefault()
