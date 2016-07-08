{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注</a></li>
        <li class="active">search:{{ search}}</li>
    </ol>
{% endblock %}
{% block content %}
    <h1>搜索：{{ search }}<span class="badge">{{ page.total_items }}</span></h1>


    {% if page.total_pages > 1 %}
        <nav>
            <ul class="pager">
                <li class="previous prev"><a href="{{ url(['for':'focus.search.page','page':page.before,'search':search]) }}">Previous</a></li>
                <li class="next"><a href="{{ url(['for':'focus.search.page','page':page.next,'search':search]) }}">Next</a></li>
            </ul>
        </nav>
    {% endif %}

    {{ partial('layouts/focuslist',['focuses':myTools.collection(page.items)]) }}

    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
