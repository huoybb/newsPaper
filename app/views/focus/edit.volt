{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注</a></li>
        <li class="active">{{ focus.title }}</li>
        <li class="active">编辑</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>关注：{{ focus.title }}</h1>

    {{ partial('layouts/editForm') }}

    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

