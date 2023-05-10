{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("keyword/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("keyword/new", "Create keyword") }}
    </li>
</ul>

{% for keyword in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>KEYWORD ID</th>
            <th>KEYWORD</th>
            <th>KEYWORD DESCRIPTION</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ keyword.ID_Keyword }}</td>
            <td>{{ keyword.KeywordName }}</td>
            <td>{{ keyword.KeywordDescription }}</td>
            <td width="7%">{{ link_to("keyword/edit/" ~ keyword.ID_Keyword, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keyword/delete/" ~ keyword.ID_Keyword, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keyword/pregledcultdomain/" ~ keyword.ID_Keyword, '<i class="glyphicon glyphicon-edit"></i> Cultural sector', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keyword/pregledsocimpact/" ~ keyword.ID_Keyword, '<i class="glyphicon glyphicon-edit"></i> Cross-over theme', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keyword/linkkeyword/" ~ keyword.ID_Keyword, '<i class="glyphicon glyphicon-edit"></i> Link to keyword', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("keyword/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("keyword/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("keyword/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("keyword/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No keywords are recorded.
{% endfor %}
