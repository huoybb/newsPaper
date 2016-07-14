{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li class="active">标签</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>标签汇总 <span class="badge">{{ tags.count() }}</span></h1>
    <div class="row">
        {% for mytag in tags %}
            <a href="{{ url(['for':'tags.show','tag':mytag.id]) }}" class="btn btn-default" data-keywords="{{ mytag.keywords }}">
                {{ mytag.name }}
                <span class="badge">{{ mytag.count }}</span>
            </a>
        {% endfor %}
    </div>
    <script src="/js/my.js" type="application/javascript"></script>
    <script src="/js/tag.filter.js" type="application/javascript"></script>

{% endblock %}

