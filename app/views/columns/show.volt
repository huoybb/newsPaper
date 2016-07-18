{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'newspapers.show','newspaper':column.getNewsPaper().id]) }}">{{ column.getNewsPaper().title }}</a></li>
        <li class="active">{{ column.present().title }}</li>
    </ol>
{% endblock %}
{% block content %}
    <div class="page-header">
        <h1>{{ column.present().title }} </h1>
    </div>
    {{ partial('layouts/pageList2',['pages':column.getPages()]) }}


{% endblock %}