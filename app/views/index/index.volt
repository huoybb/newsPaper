{% extends 'index.volt' %}
{% block content %}
    <ul>
        {% for n in newspapers  %}
            <li>
                <a href="{{ url(['for':'newspapers.show','newspaper':n.id]) }}">{{ n.title }}</a>
            </li>
        {% endfor %}
    </ul>
{% endblock %}
