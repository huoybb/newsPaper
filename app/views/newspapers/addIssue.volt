{% extends 'index.volt' %}
{% block content %}
    <div class="page-header">
        <h2>
            {{ newspaper.title }} -- 手动增加
        </h2>
    </div>

    <div>
        {#{% if auth.isLogin() %}#}
            <div class="row">
                {{ form(null, "method": "post","id":"comment-form") }}
                <!--content Form Input-->
                <div class="form-group">
                    <lable>Issue Date</lable>
                    {{ form.render('Issue_Date',['class':'form-control']) }}
                    <lable>Poster URL</lable>
                    {{ form.render('Issue_Poster_URL',['class':'form-control']) }}
                    <lable>Issue URL</lable>
                    {{ form.render('URL',['class':'form-control']) }}
                    {#{% if errors %}#}
                        {#{% for message in errors.filter('content') %}#}
                            {#<div class="alert alert-danger">{{ message.getMessage() }}</div>#}
                        {#{% endfor %}#}
                    {#{% endif %}#}

                </div>
                <!--Comment Form Submit Button-->
                <div class="form-group">
                    {{ form.render('Submit',['class':'btn btn-primary form-control']) }}
                </div>
                {{ endform() }}
            </div>
        {#{% endif %}#}
    </div>

    {#<script src="/js/keymaster.js" type="application/javascript"></script>#}
    {#<script src="/js/my.js" type="application/javascript"></script>#}
{% endblock %}
