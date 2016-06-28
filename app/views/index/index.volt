{% extends 'index.volt' %}
{% block content %}
    <ul>
        {% for n in newspapers  %}
            <li>
                <a href="{{ url(['for':'newspapers.show','newspaper':n.id]) }}">{{ n.title }}</a>
            </li>
        {% endfor %}
    </ul>
    <div>
        共计有报纸：{{ stat.getNewspaperStat()['count'] }}份
    </div>
    <div>
        共{{ stat.getIssueStat()['Total'] }}期, 已下载{{ stat.getIssueStat()['DONE'] }}期, 完成{{ stat.getIssueStat()['Completed'] }}
    </div>
    <div>
        共{{ stat.getPageStat()['Total'] }}版,已下载{{ stat.getPageStat()['IMG'] }} 版, 完成{{ stat.getPageStat()['Completed'] }}
    </div>

{% endblock %}
