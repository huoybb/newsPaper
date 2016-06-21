{% extends 'index.volt' %}
{% block pageTitle %}
    参考: {{ page.getIssue().present().title }} 第{{ page.page_num }}版
{% endblock %}
{% block title %}
    {{ page.present().title }} <a href="{{ url(['for':'pages.refresh','page':page.id]) }}">更新图片</a>
{% endblock %}
{% block content %}
    <ul class="pagination">
        <li><a href="{{ url(['for':'pages.show','page':page.prevPage().id]) }}"><<</a></li>
        {% for p in page.getIssue().getPages()  %}
            <li {% if p.id == page.id %} class="active" {% endif %}>
                <a href="{{ url(['for':'pages.show','page':p.id]) }}">{{ p.page_num }}</a>
            </li>
        {% endfor %}
        <li><a href="{{ url(['for':'pages.show','page':page.nextPage().id]) }}">>></a></li>
    </ul>

    <img src="{{ page.present().src }}" alt="{{ page.page_num }}">

    <ul class="pagination">
        <li class="prev"><a href="{{ url(['for':'pages.show','page':page.prevPage().id]) }}"><<</a></li>
        {% for p in page.getIssue().getPages()  %}
            <li {% if p.id == page.id %} class="active" {% endif %}>
                <a href="{{ url(['for':'pages.show','page':p.id]) }}">{{ p.page_num }}</a>
            </li>
        {% endfor %}
        <li class="next"><a href="{{ url(['for':'pages.show','page':page.nextPage().id]) }}">>></a></li>
    </ul>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}