{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li class="active">关注</li>
        <li class="active">search:{{ search}}</li>
    </ol>
{% endblock %}
{% block content %}
    <h1>关注新闻：<span class="badge">{{ page.total_items }}</span></h1>

    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'focus.index.page','page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'focus.index.page','page':page.next]) }}">Next</a></li>
        </ul>
    </nav>

    <table class="table table-hover">
        <tr>
            <td>#</td>
            <td>Title</td>
            {#<td>Description</td>#}
            <td>Page</td>
            <td>创建</td>
            <td>更新</td>
        </tr>
        {% for f in page.items %}
            <tr>
                <td>{{ f.id}}</td>
                <td><a href="{{ url(['for':'focus.show','focus':f.id]) }}">{{ f.title }}</a></td>
                {#<td>{{ f.description }}</td>#}
                <td><a href="{{ f.getNewsPaperUrl() }}">{{ f.getNewsPaperName() }}</a></td>
                <td>{{ f.created_at }}</td>
                <td>{{ f.updated_at }}</td>
            </tr>
        {% endfor %}
    </table>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
