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
    </head>
    <body>
        <div class="container">
            <nav class="nav">
                <div class="page-header">
                    <h1><a href="{{ url(['for':'home']) }}">我的报纸</a>{% block title %}{% endblock %}</h1>
                    {% block breadcrumbs %}{% endblock %}

                </div>
            </nav>


            {{ flash.output() }}

            {% block content %} {% endblock %}
        </div>

    </body>
</html>
