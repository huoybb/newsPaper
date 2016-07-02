{% extends 'index.volt' %}
{% block content %}
    <h1>关注点：</h1>
    <table class="table table-hover">
        <tr>
            <td>#</td>
            <td>Title</td>
            {#<td>Description</td>#}
            <td>Page</td>
            <td>创建</td>
            <td>更新</td>
        </tr>
        {% for f in focus %}
            <tr>
                <td>{{ loop.index}}</td>
                <td><a href="{{ url(['for':'focus.show','focus':f.id]) }}">{{ f.title }}</a></td>
                {#<td>{{ f.description }}</td>#}
                <td><a href="{{ f.getNewsPaperUrl() }}">{{ f.getNewsPaperName() }}</a></td>
                <td>{{ f.created_at }}</td>
                <td>{{ f.updated_at }}</td>
            </tr>
        {% endfor %}
    </table>

{% endblock %}
