{% extends 'focus.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'tags.index']) }}">标签</a></li>
        <li><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}
{% block nav %}
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'tags.showFocus','tag':mytag.id,'focus':focus.getPrevFocus(mytag).id]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'tags.showFocus','tag':mytag.id,'focus':focus.getNextFocus(mytag).id]) }}">Next</a></li>
        </ul>
    </nav>
{% endblock %}