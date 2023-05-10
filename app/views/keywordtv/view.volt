{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("keywordtv/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("keywordtv/new", "Create keyword transition variable") }}
    </li>
</ul>

{% for keywordtv in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>KEYWORD TRANS_VAR. ID</th>
            <th>KEYWORD TRANSITION VARIABLE</th>
            <th>KEYWORD TRANSITION VARIABLE DESCRIPTION</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ keywordtv.ID_Keywordtv }}</td>
            <td>{{ keywordtv.KeywordtvName }}</td>
            <td>{{ keywordtv.KeywordtvDescription }}</td>
            <td width="7%">{{ link_to("keywordtv/edit/" ~ keywordtv.ID_Keywordtv, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keywordtv/delete/" ~ keywordtv.ID_Keywordtv, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
<!--            <td width="7%">{{ link_to("keywordtv/pregledcultdomain/" ~ keywordtv.ID_Keywordtv, '<i class="glyphicon glyphicon-edit"></i> Cultural sector', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keywordtv/pregledsocimpact/" ~ keywordtv.ID_Keywordtv, '<i class="glyphicon glyphicon-edit"></i> Cross-over theme', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keywordtv/linkkeywordtv/" ~ keywordtv.ID_Keywordtv, '<i class="glyphicon glyphicon-edit"></i> Link to keyword', "class": "btn btn-default") }}</td> -->
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("keywordtv/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("keywordtv/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("keywordtv/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("keywordtv/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No keywords transitional variable are recorded.
{% endfor %}
