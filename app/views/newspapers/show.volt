{% extends 'index.volt' %}
{% block content %}
    <div class="page-header">
        <h2>{{ newspaper.title }} <a href="{{ url(['for':'fromWeb.updateNewspaper','newspaper':newspaper.id]) }}">更新</a> <a href="{{ newspaper.url }}">网站</a></h2>
    </div>
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'newspapers.show.page','newspaper':newspaper.id,'page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'newspapers.show.page','newspaper':newspaper.id,'page':page.next]) }}">Next</a></li>
        </ul>
    </nav>

    <div class="container">
        {% for issue in page.items  %}
            <div class="Card">
                <span class="Card__updated-status">{{ issue.present().status }}</span>
                <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page':issue.getFirstPage().id]) }}">
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
