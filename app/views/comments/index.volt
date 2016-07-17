{% extends 'index.volt' %}
{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li class="active">最新评论</li>
    </ol>
{% endblock %}
{% block content %}
    <h1>我的评论：<span class="badge">{{ page.total_items }}</span></h1>
    <div class="row">
        <ul class="list-unstyled list-group">
            {% for commentRow in comments %}
                <li class="list-group-item">
                    <div>
                        <h4>
                            <span>To：</span>
                            <button class="btn btn-warning btn-xs">{{ commentRow.commentable().present().type }}</button>
                            <a href="{{ commentRow.commentable().present().url }}">
                                {{ commentRow.commentable().present().title }}
                            </a>
                            <span>@ {{ commentRow.updated_at.diffForHumans() }}</span>
                        {% if gate.allows('editAndDelete',commentRow) %}
                            <span><a href="{{ url(['for':'comments.edit','comment':commentRow.id]) }}">编辑</a></span>
                            <span><a href="{{ url(['for':'comments.delete','comment':commentRow.id]) }}">删除</a></span>
                        {% endif %}
                        </h4>
                    </div>
                    <div>
                        <pre>{{commentRow.content|nl2br}}</pre>
                    </div>
                </li>
            {% endfor %}
        </ul>
    </div>
    <nav>
        <ul class="pager">
            <li class="previous prev"><a href="{{ url(['for':'comments.index.page','page':page.before]) }}">Previous</a></li>
            <li class="next"><a href="{{ url(['for':'comments.index.page','page':page.next]) }}">Next</a></li>
        </ul>
    </nav>
    <script src="/js/keymaster.js" type="application/javascript"></script>
    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}
