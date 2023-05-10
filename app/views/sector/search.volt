{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("sector/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("sector/new", "Create sector") }}
    </li>
</ul>

{% for sector in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>CULTURAL DOMAIN ID</th>
            <th>CULTURAL DOMAIN NAME</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ sector.ID_Sector }}</td>
            <td>{{ sector.SectorName }}</td>
                <td width="7%">{{ link_to("sector/edit/" ~ sector.ID_Sector, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("sector/delete/" ~ sector.ID_Sector, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("sector/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("sector/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("sector/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("sector/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No cultural domain are recorded
{% endfor %}
