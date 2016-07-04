{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li class="active">关注</li>
    </ol>
{% endblock %}
{% block content %}
    <h1>关注新闻：<span class="badge">{{ page.total_items }}</span></h1>
    {{ partial('layouts/focusList',['focuses':page.items]) }}
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'focus.index.page','page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'focus.index.page','page':page.next]) }}">Next</a></li>
        </ul>
    </nav>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
