{% extends 'page.volt' %}
{% block pageTitle %}
    参考: {{ page.getIssue().present().date }} 第{{ page.page_num }}版
{% endblock %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'newspapers.show','newspaper':issue.getNewsPaper().id]) }}">{{ issue.getNewsPaper().title }}</a></li>
        <li><a href="{{ url(['for':'issues.show','issue':issue.id]) }}">{{ issue.present().date }}</a></li>
        <li class="active">第{{ page.present().page_num }}版 -- {{ page.present().showfileName }}</li>
        {% if page.hasColumn() %}
            <li><a href="{{ url(['for':'columns.showPage','column':page.getColumn().id,'page':page.id]) }}">{{ page.getColumn().title }}</a></li>
        {% endif %}
        <li><a href="{{ url(['for':'fromWeb.refreshPage','page':page.id]) }}" class="badge">更新本页</a></li>
    </ol>

{% endblock %}
{% block content %}
    <img src="{{ page.present().src }}" alt="{{ page.page_num }}">

    <ul class="pagination">
        <li class="prev"><a href="{{ url(['for':'issues.showPage','issue':issue.id,'page_num':page.prevPage().page_num]) }}"><<</a></li>
        {% for p in page.getIssue().getPages()  %}
            <li {% if p.id == page.id %} class="active" {% endif %}>
                <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page_num':p.page_num]) }}">{{ p.page_num }}</a>
            </li>
        {% endfor %}
        <li class="next"><a href="{{ url(['for':'issues.showPage','issue':issue.id,'page_num':page.nextPage().page_num]) }}">>></a></li>
    </ul>

    {{ partial('layouts/focusList',['focuses':page.getFocuses()]) }}

    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

