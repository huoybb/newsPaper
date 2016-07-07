<div class="container">
    {% for issue in page.items  %}
        <div class="Card">
            <span class="Card__updated-status">{{ issue.present().status }}</span>
            <a href="{{ url(['for':'issues.showPage','issue':issue.id,'page_num':issue.getFirstPage().page_num]) }}">
                {#<a href="{{ url(['for':'issues.show','issue':issue.id]) }}">#}
                <img src="{{ issue.present().poster }}" alt="Poster" class="Card__image">
                {{ issue.present().date }}
            </a>
            {{ issue.pages }}版 <a href="{{ url(['for':'issues.show','issue':issue.id]) }}">管理</a>
        </div>
    {% endfor %}
</div>