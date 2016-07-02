<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>{% block pageTitle %}我的报纸{% endblock %}</title>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/main.css">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/js/jquery-2.1.4.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="/js/bootstrap.min.js"></script>

        <!--Vex 设置 -->
        <script src="/js/vex.combined.min.js"></script>
        <script>vex.defaultOptions.className = 'vex-theme-bottom-right-corner';</script>
        <link rel="stylesheet" href="/css/vex.css" />
        <link rel="stylesheet" href="/css/vex-theme-bottom-right-corner.css" />
    </head>
    <body>

        <div class="container myContainer">
            {#<nav class="nav navbar-fixed-top navbar-inverse">#}
                {#<div class="page-header">#}
                    {#<h1><a href="{{ url(['for':'home']) }}">我的报纸</a>{% block title %}{% endblock %}</h1>#}
                {#</div>#}
            {#</nav>#}
            {{ partial('layouts/header') }}
            <div class="row">
                {% block breadcrumbs %}{% endblock %}
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        {{ flash.output() }}
                    </div>
                    <div class="row">
                        {% block content %} {% endblock %}
                    </div>
                </div>
                <div class="col-md-3">{% block sidebar %}{% endblock %}</div>
            </div>

        </div>

    </body>
</html>
