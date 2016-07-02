{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注点</a></li>
        <li><a href="{{ url(['for':'focus.show','focus':focus.id]) }}">{{ focus.title }}</a></li>
        <li class="active">标签</li>
    </ol>
{% endblock %}
{% block content %}
    <h1>关注点：{{ focus.title }}</h1>
    <pre>    {{ focus.description }}</pre>
    <p>
        <span>赵兵@{{ focus.created_at.diffForHumans() }} </span>
    </p>

    <table class="table table-hover">
        <tr>
            <td>#</td>
            <td>Name</td>
            <td>操作</td>
        </tr>
        {% for mytag in focus.getTags() %}
            <tr>
                <td>{{ mytag.id}}</td>
                <td><a href="{{ url(['for':'tags.show','tag':mytag.id]) }}">{{ mytag.name }}</a></td>
                <td><a href="{{ url(['for':'focus.deleteTag','focus':focus.id,'tag':mytag.id]) }}">删除</a></td>
            </tr>
        {% endfor %}
    </table>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
