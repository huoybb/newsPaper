{% extends 'focus/show.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'tags.index']) }}">标签</a></li>
        <li><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}
