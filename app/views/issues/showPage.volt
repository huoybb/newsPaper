{% extends 'index.volt' %}
{% block pageTitle %}
    参考: {{ page.getIssue().present().date }} 第{{ page.page_num }}版
{% endblock %}
{% block title %}
    <a href="{{ url(['for':'pages.refresh','page':page.id]) }}" class="badge">更新本页</a>
{% endblock %}
{% block content %}
    <img src="{{ page.present().src }}" alt="{{ page.page_num }}">

    <ul class="pagination">
        <li class="prev"><a href="{{ url(['for':'issues.showPage','issue':issue.id,'page':page.prevPage().id]) }}"><<</a></li>
        {% for p in page.getIssue().getPages()  %}
            <li {% if p.id == page.id %} class="active" {% endif %}>
                <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page':p.id]) }}">{{ p.page_num }}</a>
            </li>
        {% endfor %}
        <li class="next"><a href="{{ url(['for':'issues.showPage','issue':issue.id,'page':page.nextPage().id]) }}">>></a></li>
    </ul>

    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'newspapers.show','newspaper':issue.getNewsPaper().id]) }}">{{ issue.getNewsPaper().title }}</a></li>
        <li><a href="{{ url(['for':'issues.show','issue':issue.id]) }}">{{ issue.present().date }}</a></li>
        <li class="active">第{{ page.present().page_num }}版</li>
    </ol>

{% endblock %}