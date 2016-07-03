{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>关注点：{{ focus.title }}</h1>
    <pre>    {{ focus.description }}</pre>
    <p>
        <span>赵兵@{{ focus.created_at.diffForHumans() }} </span>
        <a href="{{ url(['for':'focus.delete','focus':focus.id]) }}" class="btn btn-default">删除</a>
        <a href="#" class="btn btn-default">编辑</a>
        <a href="#" class="btn btn-danger addTag">添加标签</a>
        <a href="#" class="btn btn-danger addComment">添加评论</a>
    </p>
    {{ partial('layouts/tags',['tagOwner':focus]) }}
    {{ partial('layouts/inlineNews',['scrollTop':focus.Y,'url':focus.getNewsPaperUrl(false),'sourceInfo':focus.getNewsPaperName()]) }}
    {{ partial('layouts/comments',['commentOwner':focus]) }}
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'focus.show','focus':focus.getPrevFocus().id]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'focus.show','focus':focus.getNextFocus().id]) }}">Next</a></li>
        </ul>
    </nav>

    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

{#{% block sidebar %}#}
    {#<h2>标签</h2>#}

{#{% endblock %}#}
