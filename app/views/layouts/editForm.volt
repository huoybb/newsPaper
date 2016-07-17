{{ form("method": "post") }}
    {% for item in form.fields %}
        <div class="form-group">
            <label for="{{ item }}">{{ item }}</label>
            {% if true %}
                {{ form.render(item,['class':'form-control','rows':4]) }}<br/>
            {% else %}
                {{ form.render(item,['class':'form-control']) }}<br/>
            {% endif %}
        </div>
    {% endfor %}
    <div class="form-group">
        {{ form.render('修改',['class':'btn btn-primary form-control']) }}
    </div>
{{ endform() }}