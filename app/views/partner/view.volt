{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("partner/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("partner/new", "Create partner") }}
    </li>
</ul>

{% for partner in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>PARTNER NUMBER</th>
            <th>PARTNER</th>
            <th>PARTNER ACRONIM</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ partner.PartnerNumber }}</td>
            <td>{{ partner.PartnerName }}</td>
            <td>{{ partner.PartnerAcr }}</td>
            <td width="7%">{{ link_to("partner/edit/" ~ partner.ID_Partner, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("partner/delete/" ~ partner.ID_Partner, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("partner/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("partner/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("partner/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("partner/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No partner are recorded
{% endfor %}
