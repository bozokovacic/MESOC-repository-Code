{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("template", "&larr; Search") }}
    </li>
   <!-- <li class="next">
        {{ link_to("template/new", "New template") }}
    </li> -->
</ul>

<H3> KEYWORD </H3>
<?php echo $keyword; ?>
{{ templatekeyword.ID_Template }}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>KEYWORD TEMPLATE</th>
            <th>KEYWORD DOCUMENT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ templatekeyword.Keyword }}</td>
            <td>{{ templatekeyword.Keyword }}</td>
            <td width="7%">{{ link_to("template/edit/" ~ templatekeyword.ID_TemplateKeyword, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>            
            <td width="7%">{{ link_to("template/templatekeywordcultdomainsocimpact/" ~ template.ID_Template, '<i class="glyphicon glyphicon-edit"></i> Cult domain & soc. impact', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("template/pregled/" ~ template.ID_Template, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("template/check/" ~ template.ID_Template, '<i class="glyphicon glyphicon-remove"></i> Checked', "class": "btn btn-primary") }}</td>
    </tr>
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    {{ link_to("template/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("template/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("template/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("template/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

{{ form("keyword/search") }}

<h2>KEYWORDS OVERVIEW</h2>

<fieldset>

{% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
{{ element }}
    {% else %}
<div class="control-group">
    {{ element.label(['class': 'control-label']) }}
    <div class="controls">
        {{ element }}
    </div>
</div>
    {% endif %}
{% endfor %}

<div class="control-group">
    {{ submit_button("Search", "class": "btn btn-primary") }}
</div>

</fieldset>