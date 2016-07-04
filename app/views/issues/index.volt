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

    <div class="container">
        {% for issue in page.items  %}
            <div class="Card">
                <span class="Card__updated-status">{{ issue.present().status }}</span>
                <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page_num':1]) }}">
                    {#<a href="{{ url(['for':'issues.show','issue':issue.id]) }}">#}
                    <img src="{{ issue.present().poster }}" alt="Poster" class="Card__image">
                    {{ issue.present().date }}
                </a>
                {{ issue.pages }}版 <a href="{{ url(['for':'issues.show','issue':issue.id]) }}">管理</a>
            </div>
        {% endfor %}

    </div>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
