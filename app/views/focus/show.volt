{% extends 'focus.volt' %}
{% block pageTitle %}
    关注：{{ focus.title }}
{% endblock %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}

{% block nav %}
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'focus.show','focus':focus.getPrevFocus().id]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'focus.show','focus':focus.getNextFocus().id]) }}">Next</a></li>
        </ul>
    </nav>
{% endblock %}
