{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li class="active">{{ newspaper.title }}</li>
    </ol>
{% endblock %}
{% block content %}
    <div class="page-header">
        <h2>
            {{ newspaper.title }}
            <a href="{{ url(['for':'fromWeb.updateNewspaper','newspaper':newspaper.id]) }}">更新</a>
            <a href="{{ newspaper.url }}" target="_blank">网站</a>
            <a href="{{ url(['for':'newspapers.addIssue','newspaper':newspaper.id]) }}">手动增加</a>
        </h2>
    </div>
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'newspapers.show.page','newspaper':newspaper.id,'page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'newspapers.show.page','newspaper':newspaper.id,'page':page.next]) }}">Next</a></li>
        </ul>
    </nav>
    {% if newspaper.getColumns() %}
        {{ partial('layouts/columnList',['columns':newspaper.getColumns()]) }}
    {% endif %}
    {{ partial('layouts/pageList') }}
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
