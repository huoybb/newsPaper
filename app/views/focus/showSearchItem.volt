{% extends 'focus.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注</a></li>
        <li class="active"><a href="{{ url(['for':'focus.search','search':search]) }}">search:{{ search}}</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}

{% block nav %}
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'focus.search.showItem','focus':focus.getPrevFocus().id,'search':search]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'focus.search.showItem','focus':focus.getNextFocus().id,'search':search]) }}">Next</a></li>
        </ul>
    </nav>
{% endblock %}
