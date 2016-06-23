{% extends 'index.volt' %}
{% block content %}
    <div class="page-header">
        <h1>{{ issue.title }}</h1>
        操作：<a href="{{ url(['for':'issues.delete','issue':issue.id]) }}">删除</a>
    </div>

    <ul>
        {% for page in issue.getPages()  %}
            <li><a href="{{ url(['for':'pages.show','page':page.id]) }}">{{ page.page_num }}</a></li>
        {% endfor %}
    </ul>
{% endblock %}