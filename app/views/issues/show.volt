{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'newspapers.show','newspaper':issue.getNewsPaper().id]) }}">{{ issue.getNewsPaper().title }}</a></li>
        <li class="active">{{ issue.present().date }}</li>
    </ol>
{% endblock %}
{% block content %}
    <div class="page-header">
        <h1>{{ issue.present().title }} 共{{ issue.getPages().count() }}版</h1>
        操作：
        {% if gate.allows('deleteAndUpdate',issue) %}
            <a href="{{ url(['for':'issues.delete','issue':issue.id]) }}">删除</a>
            <a href="{{ url(['for':'fromWeb.updateIssue','issue':issue.id]) }}">更新</a>
        {% endif %}
        <a href="{{ issue.url }}">网站</a>
    </div>

    <hr>
    {{ partial('layouts/focusList',['focuses':issue.getFocuses()]) }}
    {{ partial('layouts/pageList2',['pages':issue.getPages()]) }}
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}