{% extends 'page.volt' %}
{% block pageTitle %}
    参考: {{ page.getIssue().present().date }} 第{{ page.page_num }}版
{% endblock %}
{% block title %}
    <a href="{{ url(['for':'fromWeb.refreshPage','page':page.id]) }}" class="badge">更新本页</a>
{% endblock %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'newspapers.show','newspaper':column.getNewsPaper().id]) }}">{{ column.getNewsPaper().title }}</a></li>
        <li class="active"><a href="{{ url(['for':'columns.show','column':column.id]) }}">{{ column.present().title }}</a></li>
        <li><a href="{{ url(['for':'issues.showPage','issue':page.getIssue().id,'page_num':page.page_num]) }}">{{ page.getIssue().date }}</a></li>
    </ol>

{% endblock %}
{% block content %}
    <img src="{{ page.present().src }}" alt="{{ page.page_num }}">

    <ul class="pagination">
        <li class="prev"><a href="{{ url(['for':'columns.showPage','column':column.id,'page':page.prevPage().id]) }}"><<</a></li>
        {% for p in column.getPages()  %}
            <li {% if p.id == page.id %} class="active" {% endif %}>
                <a href="{{ url(['for':'columns.showPage','column':column.id,'page':p.id]) }}">{{ p.id }}</a>
            </li>
        {% endfor %}
        <li class="next"><a href="{{ url(['for':'columns.showPage','column':column.id,'page':page.nextPage().id]) }}">>></a></li>
    </ul>

    {{ partial('layouts/focusList',['focuses':page.getFocuses()]) }}

    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

