<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="/">我的报纸</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li><a href="#">阅读</a></li>
                <li><a href="/focus">关注</a></li>
                <li><a href="/tags">标签</a></li>
                {#<li>#}
                    {#<ul class="nav navbar-nav navbar-header">#}
                        {#<li class="dropdown">#}
                            {#<a href="/skills" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">技能 <span class="caret"></span></a>#}
                            {#<ul class="dropdown-menu">#}
                                {#{% for row in myTools.getSkills()  %}#}
                                    {#<li><a href="{{ url(['for':'skills.show','name':row.name]) }}">{{ row.name }}</a></li>#}
                                {#{% endfor %}#}
                                {#<li role="separator" class="divider"></li>#}
                                {#<li><a href="/skills">技能首页</a></li>#}
                            {#</ul>#}
                        {#</li>#}
                    {#</ul>#}
                {#</li>#}

            </ul>


            <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" class="setFocusAction">设置关注</a></li>
                    <li><a href="#">注册</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form id="search-form" class="navbar-form navbar-left" role="search">
                            {{ text_field("search",'class':'form-control','placeholder':'Search','value':search) }}
                            <button type="submit" class="btn btn-default">查询</button>
                    </form>
                    {#<script src="/js/search.js"></script>#}
                </li>
            </ul>
        </div>
    </div>
</nav>