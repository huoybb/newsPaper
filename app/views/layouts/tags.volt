{% if tagOwner.hasAnyTags() %}
    <div class="row">
        <h2>
            <a href="{{ url(['for':'focus.showTags','focus':tagOwner.id]) }}"><span>拥有的标签</span></a>：
            {% for mytag in tagOwner.getTags()  %}
                <a href="{{ url(['for':'tags.show','tag':mytag.id]) }}" class="btn btn-default">{{ mytag.name }}</a>
            {% endfor %}
        </h2>
    </div>
{% endif %}