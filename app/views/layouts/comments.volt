{% if commentOwner.hasAnyComments() %}
    <h2>评论:</h2>
    <ul>
        {% for comment in commentOwner.getComments() %}
            <li>
                <div>
            <span>
                by <a href="#">{{ comment.user().name }}</a>
            </span>
                    --
            <span>
                at: {{ comment.updated_at.diffForHumans() }}
            </span>
                    {% if gate.allows('editAndDelete',comment) %}
                        <span><a href="{{ url(['for':'comments.edit','comment':comment.id]) }}">edit</a></span>
                        <span><a href="{{ url(['for':'comments.delete','comment':comment.id]) }}">delete</a></span>
                    {% endif %}
                </div>
                <div>
                    {{comment.content|nl2br}}
                </div>
            </li>
        {% endfor %}
    </ul>
{% endif %}