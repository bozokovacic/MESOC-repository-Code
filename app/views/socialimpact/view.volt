{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("socialimpact/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("socialimpact/new", "Create cross-over theme") }}
    </li>
</ul>

{% for socialimpact in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>CROSS-OVER THEME</th>
            <th>CROSS-OVER THEME DESCRIPTION</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ socialimpact.SocImpactName }}</td>
            <td>{{ socialimpact.SocImpactDescription }}</td>
            <td width="7%">{{ link_to("socialimpact/edit/" ~ socialimpact.ID_SocImpact, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("socialimpact/delete/" ~ socialimpact.ID_SocImpact, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("socialimpact/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("socialimpact/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("socialimpact/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("socialimpact/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No cross-over theme are recorded
{% endfor %}
