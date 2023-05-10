{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("beneficiary/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("beneficiary/new", "Create beneficiary") }}
    </li>
</ul>

{% for beneficiary in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>BENEFICIARY ID</th>
            <th>BENEFICIARY NAME</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ beneficiary.ID_Beneficiary }}</td>
            <td>{{ beneficiary.BeneficiaryName }}</td>
                <td width="7%">{{ link_to("beneficiary/edit/" ~ beneficiary.ID_Beneficiary, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("beneficiary/delete/" ~ beneficiary.ID_Beneficiary, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("beneficiary/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("beneficiary/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("beneficiary/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("beneficiary/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No beneficiary are recorded
{% endfor %}
