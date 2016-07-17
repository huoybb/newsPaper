{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'tags.index']) }}">标签</a></li>
        <li class="active">{{ mytag.name }}</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>标签：{{ mytag.name }}</h1>
    <pre>    {{ mytag.description }}</pre>
    <div class="row container">关键词：{{ mytag.keywords }}</div>
    <p>
        <span>赵兵@{{ mytag.created_at.diffForHumans() }} </span>
        {% if gate.allows('editAndDelete',mytag) %}
            <a href="{{ url(['for':'tags.delete','tag':mytag.id]) }}" class="btn btn-default">删除</a>
            <a href="{{ url(['for':'tags.edit','tag':mytag.id]) }}" class="btn btn-default">编辑</a>
        {% endif %}
        {% if gate.allows('addComment',mytag) %}
            <a href="#" class="btn btn-danger addComment">添加评论</a>
        {% endif %}
    </p>
    <div class="row container">
        <h2>关注点 <span class="badge">{{ mytag.getFocus().count() }}</span></h2>
        {{ partial('layouts/focuslist',['focuses':mytag.getFocus()]) }}
    </div>
    {{ partial('layouts/commentform') }}
    {{ partial('layouts/comments',['commentOwner':mytag]) }}
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

