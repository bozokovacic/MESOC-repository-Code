{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("relevance/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("relevance/new", "Create relevance") }}
    </li>
</ul>

{% for relevance in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>RELEVANCE ID</th>
            <th>RELEVANCE</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ relevance.ID_Relevance }}</td>
            <td>{{ relevance.Relevance }}</td>
            <td with="7%">{{ link_to("relevance/edit/" ~ relevance.ID_Relevance, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("relevance/delete/" ~ relevance.ID_Relevance, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("relevance/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("relevance/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("relevance/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Nest', "class": "btn") }}
                    {{ link_to("relevance/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No relevance are recorded
{% endfor %}
