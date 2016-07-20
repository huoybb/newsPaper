{% if focuses.count() %}
    <table class="table table-hover">
        <tr>
            <td>#</td>
            <td>标题</td>
            <td>栏目</td>
            <td>标签</td>
            <td>创建</td>
        </tr>
        {% for f in focuses %}
            <tr>
                <td>{{ f.id}}</td>
                <td>
                    {% if router.getMatchedRoute().getName() is 'tags.show' %}
                        <a href="{{ url(['for':'tags.showFocus','tag':mytag.id,'focus':f.id]) }}">{{ f.title }}</a>
                    {% elseif router.getMatchedRoute().getName() is 'focus.search' or router.getMatchedRoute().getName() is 'focus.search.page' %}
                        <a href="{{ url(['for':'focus.search.showItem','focus':f.id,'search':search]) }}">{{ f.title }}</a>
                    {% else %}
                        <a href="{{ url(['for':'focus.show','focus':f.id]) }}">{{ f.title }}</a>
                    {% endif %}
                </td>
                <td><a href="{{ f.getNewsPaperUrl() }}">{{ f.getPage().getColumn().title }}</a></td>
                <td>
                    {% for rowtag in f.getTags()  %}
                        <a href="{{ url(['for':'tags.show','tag':rowtag.id]) }}" class="btn btn-warning btn-xs">{{ rowtag.name }}</a>
                    {% endfor %}
                </td>
                <td>{{ f.created_at.diffForHumans() }}</td>
            </tr>
        {% endfor %}
    </table>
{% endif %}