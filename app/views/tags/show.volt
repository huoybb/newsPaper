{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'tags.index']) }}">标签</a></li>
        <li class="active">{{ mytag.name }}</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>标签：{{ mytag.name }}</h1>
    <pre>    标签的描述，这个需要后续增加</pre>
    <p>
        <span>赵兵@{{ mytag.created_at.diffForHumans() }} </span>
        <a href="{{ url(['for':'tags.delete','tag':mytag.id]) }}" class="btn btn-default">删除</a>
        <a href="#" class="btn btn-default">编辑</a>
        <a href="#" class="btn btn-danger addComment">添加评论</a>
    </p>
    <div class="row container">
        <h2>关注点 <span class="badge">{{ mytag.getFocus() | length }}</span></h2>
        <table class="table table-hover">
            <tr>
                <td>#</td>
                <td>关注点</td>
                <td>报纸</td>
                <td>更新</td>
            </tr>
            {% for focus in mytag.getFocus()  %}
                <tr>
                    <td>{{ loop.index }}</td>
                    <td><a href="{{ url(['for':'tags.showFocus','tag':mytag.id,'focus':focus.id]) }}">{{ focus.title }}</a></td>
                    <td><a href="{{ focus.getNewsPaperUrl() }}">{{ focus.getNewsPaperName() }}</a></td>
                    <td>{{ focus.addTagTime }}</td>
                </tr>
            {% endfor %}
        </table>
    </div>
    {{ partial('layouts/comments',['commentOwner':mytag]) }}
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

