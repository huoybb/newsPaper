{% extends 'index.volt' %}
{% block content %}
    <div class="page-header">
        <h2>参考消息 <a href="{{ url(['for':'updateFromWeb','newspaper':1]) }}">更新</a></h2>
    </div>
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'home.page','page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'home.page','page':page.next]) }}">Next</a></li>
        </ul>
    </nav>

    <ul>
        {% for issue in page.items  %}
            <li>

                <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page':issue.getFirstPage().id]) }}">
                {#<a href="{{ url(['for':'issues.show','issue':issue.id]) }}">#}
                    {#<img src="{{ issue.present().poster }}" alt="Poster">#}
                    {{ issue.present().date }}
                </a>
                {{ issue.pages }}版 <a href="{{ url(['for':'issues.show','issue':issue.id]) }}">管理</a>
            </li>
        {% endfor %}

    </ul>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
