<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{% block pageTitle %}我的报纸{% endblock %}</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/main.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery-2.1.4.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <!--Vex 设置 -->
    <script src="/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-bottom-right-corner';</script>
    <link rel="stylesheet" href="/css/vex.css" />
    <link rel="stylesheet" href="/css/vex-theme-bottom-right-corner.css" />
</head>
<body>

<div class="container myContainer">
    {#<nav class="nav navbar-fixed-top navbar-inverse">#}
    {#<div class="page-header">#}
    {#<h1><a href="{{ url(['for':'home']) }}">我的报纸</a>{% block title %}{% endblock %}</h1>#}
    {#</div>#}
    {#</nav>#}
    {{ partial('layouts/header') }}
    <div class="row">
        {% block breadcrumbs %}{% endblock %}
    </div>
    <div class="row">
        {{ flash.output() }}
    </div>
    <div class="row">
        <h1>关注点：{{ focus.title }}</h1>
        <pre>    {{ focus.description }}</pre>
        <p>
            <span>{{ focus.user().name }}@{{ focus.created_at.diffForHumans() }} </span>
            {% if gate.allows('delete',focus) %}
                <a href="{{ url(['for':'focus.delete','focus':focus.id]) }}" class="btn btn-default">删除</a>
            {% endif %}
            {% if gate.allows('edit',focus) %}
                <a href="{{ url(['for':'focus.edit','focus':focus.id]) }}" class="btn btn-default">编辑</a>
            {% endif %}
            {% if gate.allows('addTag',auth.user()) AND gate.allows('addComment',auth.user()) %}
                <a href="#" class="btn btn-danger addTag">添加标签</a>
                <a href="#" class="btn btn-danger addComment">添加评论</a>
            {% endif %}

        </p>
        {{ partial('layouts/tags',['tagOwner':focus]) }}
        {{ partial('layouts/inlineNews',['scrollTop':focus.Y,'url':focus.getNewsPaperUrl(false),'sourceInfo':focus.getNewsPaperName()]) }}
        {{ partial('layouts/commentform') }}
        {{ partial('layouts/comments',['commentOwner':focus]) }}

        {% block nav %}{% endblock %}

        <script src="/js/keymaster.js" type="application/javascript"></script>
        <script src="/js/my.js" type="application/javascript"></script>

    </div>

</div>

</body>
</html>
