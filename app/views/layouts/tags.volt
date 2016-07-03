{% if tagOwner.hasAnyTags() %}
    <div class="row container">
        <h2>
            <a href="{{ url(['for':'focus.showTags','focus':tagOwner.id]) }}"><span>标签</span></a>：
            {% for mytag in tagOwner.getTags()  %}
                <a href="{{ url(['for':'tags.show','tag':mytag.id]) }}" class="btn btn-warning">{{ mytag.name }}</a>
            {% endfor %}
        </h2>
    </div>
{% endif %}