{% extends 'index.volt' %}

{% block breadcrumbs %}
    <ol class="breadcrumb">
        <li><a href="{{ url(['for':'home']) }}">Home</a></li>
        <li class="active">登录</li>
    </ol>
{% endblock %}

{% block content %}
    <h1>登录</h1>

{{ form('method': 'post') }}
    <div class="form-group">
        <label for="name">Name</label>
        {{ text_field("name", "size": 32,'class':'form-control') }}

        <label for="password">Password</label>
        {{ password_field("password", "size": 30,'class':'form-control') }}
    </div>
    <div class="form-group">
        {{ submit_button('确认','class':'btn btn-primary form-control') }}
    </div>

{{ endform() }}

    <script src="/js/my.js" type="application/javascript"></script>
{% endblock %}

