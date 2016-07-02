{% if commentOwner.hasAnyComments() %}
    <h2>Comments:</h2>
    <ul>
        {% for comment in commentOwner.getComments() %}
            <li>
                <div>
            <span>
                by <a href="#">赵兵</a>
            </span>
                    --
            <span>
                at: {{ comment.updated_at.diffForHumans() }}
            </span>
                    {#{% if auth.has(comment) %}#}
                        <span><a href="#">edit</a></span>
                        <span><a href="#">delete</a></span>
                    {#{% endif %}#}
                </div>
                <div>
                    {{comment.content|nl2br}}
                </div>
            </li>
        {% endfor %}
    </ul>
{% endif %}