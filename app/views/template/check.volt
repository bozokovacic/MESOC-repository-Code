{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("template/view", "&larr; Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("document/createdocumenttemplate", "Create document from template") }}
    </li>
</ul>

<h3>KEYWORD DATA</h3>


{% for templatekeyword in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ID TEMPLATE</th>
            <th>KEYWORD NUMBER</th>
            <th>KEYWORD TEMPLATE</th>
            <th>KEYWORD DOCUMENT</th>           
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ templatekeyword.ID_Template }}</td>           
            <td>{{ templatekeyword.ID_TemplateKeyword }}</td>           
            <td>{{ templatekeyword.Keyword }}</td> 
            <td>{{ templatekeyword.getKeyword().KeywordName }}</td>           
            <td width="7%">{{ link_to("template/definekeyword/" ~ templatekeyword.ID_TemplateKeyword, '<i class="glyphicon glyphicon-edit"></i> Define', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("template/templatecultdomainsocimpact/" ~ templatekeyword.ID_Template, '<i class="glyphicon glyphicon-edit"></i> Cult domain & soc. impact', "class": "btn btn-default") }}</td>
            {% switch templatekeyword.ID_Keyword %}
                    {% case  0  %}
                        <td width="7%">{{ link_to("template/check/" ~ templatekeyword.ID_Template, '<i class="glyphicon glyphicon-remove"></i>', "class": "btn btn-primary") }}</td> 
                      {% break %}
                    {% default  %}
                        <td width="7%">{{ link_to("template/check/" ~ templatekeyword.ID_Template, '<i class="glyphicon glyphicon-check"></i>', "class": "btn btn-success") }}</td> 
                      {% break %} 
                {% endswitch %}
       </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("templatereview/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("templatereview/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("templatereview/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("templatereview/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No template are recorded
{% endfor %}
