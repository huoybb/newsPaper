<h3>报纸栏目</h3>
{% for column in columns  %}
    <span class="btn btn-default"><a href="{{ url(['for':'columns.show','column':column.id]) }}">{{ column.title }}</a></span>
{% endfor %}
<hr>