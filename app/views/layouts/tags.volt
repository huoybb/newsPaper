{% if tagOwner.hasAnyTags() %}
    <div class="row">
        <h2>
            <span>拥有的标签：</span>
            {% for mytag in tagOwner.getTags()  %}
                <a href="{{ url(['for':'tags.show','tag':mytag.id]) }}" class="btn btn-default">{{ mytag.name }}</a>
            {% endfor %}
        </h2>
    </div>
{% endif %}