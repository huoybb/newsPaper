{% extends 'index.volt' %}
{% block content %}
    <div class="page-header">
        <h2>参考消息 <a href="{{ url(['for':'updateFromWeb','newspaper':1]) }}">更新</a></h2>
    </div>

    <ul>
        {% for issue in Issues  %}
            <li>

                <a href="{{ url(['for':'pages.show','page':issue.getFirstPage().id]) }}">
                    <img src="{{ issue.present().poster }}" alt="Poster">
                    {{ issue.present().date }}
                </a>
                {{ issue.pages }}版
            </li>
        {% endfor %}

    </ul>
{% endblock %}
