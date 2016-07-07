{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li class="active">Home</li>
    </ol>
{% endblock %}
{% block content %}
    <div class="page-header">
        <h2>
            最新报纸
        </h2>
    </div>
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'issues.index.page','page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'issues.index.page','page':page.next]) }}">Next</a></li>
        </ul>
    </nav>

    {{ partial('layouts/pageList') }}

    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
