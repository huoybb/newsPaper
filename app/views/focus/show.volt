{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li><a href="{{ url(['for':'focus.index']) }}">关注点</a></li>
        <li class="active">{{ focus.title }}</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>关注点：{{ focus.title }}</h1>
    <pre>    {{ focus.description }}</pre>
    <p>
        <span>赵兵@{{ focus.created_at.diffForHumans() }} </span>
        <a href="{{ url(['for':'focus.delete','focus':focus.id]) }}" class="btn btn-default">删除</a>
        <a href="#" class="btn btn-default">编辑</a>
        <a href="#" class="btn btn-default addTag">添加标签</a>
    </p>
    {{ partial('layouts/inlineNews',['scrollTop':focus.Y,'url':focus.getNewsPaperUrl(false)]) }}
    {% if focus.hasTags() %}
        <div class="row">
            <h2>
                <span>拥有的标签：</span>
                {% for mytag in focus.getTags()  %}
                    <a href="#" class="btn btn-default">{{ mytag.name }}</a>
                {% endfor %}
            </h2>
        </div>
    {% endif %}
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

{% block sidebar %}
    <h2>标签</h2>

{% endblock %}
