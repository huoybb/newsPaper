{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'comments.index']) }}">评论汇总</a></li>
        <li class="active">评论编辑</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>评论编辑</h1>

    {{ partial('layouts/editForm') }}

    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

