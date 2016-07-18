<div class="row">
    <div class="container">
        {% for page in pages %}
            <div class="Card">
                <a href="
                {% if router.getMatchedRoute().getName() is 'issues.show' %}
                   {{ url(['for':'issues.showPage','issue':issue.id,'page_num':page.page_num]) }}
                {% elseif router.getMatchedRoute().getName() is 'columns.show' %}
                    {{ url(['for':'columns.showPage','column':column.id,'page':page.id]) }}
                {% endif %}
                ">
                    <img src="{{ page.present().src }}" alt="Poster" class="Card__image">
                </a>
                <span>第{{ page.page_num }}版</span>
                {% if page.hasColumn() %}
                    <span><a href="{{ url(['for':'columns.show','column':page.getColumn().id]) }}">{{ page.getColumn().title }}</a></span>
                {% endif %}
            </div>
        {% endfor %}
    </div>
</div>