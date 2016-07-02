{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注点</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>关注点：{{ focus.title }}</h1>
    <pre>    {{ focus.description }}</pre>
    <p>Published on {{ focus.created_at }}</p>
    {{ partial('layouts/inlineNews',['scrollTop':focus.Y,'url':focus.getNewsPaperUrl(false)]) }}
{% endblock %}

{% block sidebar %}
    <h2>标签</h2>

{% endblock %}
