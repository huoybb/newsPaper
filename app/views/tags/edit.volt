{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'tags.index']) }}">标签</a></li>
        <li class="active">{{ mytag.name }}</li>
        <li class="active">编辑</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>标签：{{ mytag.name }}</h1>

    {{ partial('layouts/editForm') }}

    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

