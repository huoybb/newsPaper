{{ form("method": "post") }}
    {% for item in form.fields %}
        <div class="form-group">
            <label for="{{ item }}">{{ item }}</label>
            {{ form.render(item,['class':'form-control']) }}<br/>
        </div>
    {% endfor %}
    <div class="form-group">
        {{ form.render('修改',['class':'btn btn-primary form-control']) }}
    </div>
{{ endform() }}