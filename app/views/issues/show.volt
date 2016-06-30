{% extends 'index.volt' %}
{% block content %}
    <div class="page-header">
        <h1>{{ issue.title }}</h1>
        操作：
        <a href="{{ url(['for':'issues.delete','issue':issue.id]) }}">删除</a>
        <a href="{{ url(['for':'fromWeb.updateIssue','issue':issue.id]) }}">更新</a>
        <a href="{{ issue.url }}">网站</a>
    </div>

    <hr>
    <div class="row">
        <div class="container">
            {% for page in issue.getPages()  %}
                <div class="Card">
                    <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page_num':page.page_num]) }}">
                        <img src="{{ page.present().src }}" alt="Poster" class="Card__image">
                    </a>
                    <span>第{{ page.page_num }}版</span>
                </div>
            {% endfor %}
        </div>
    </div>
{% endblock %}