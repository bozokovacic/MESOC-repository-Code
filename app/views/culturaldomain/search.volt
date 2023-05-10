{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("culturaldomain/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("culturaldomain/new", "Cultural sector impact") }}
    </li>
</ul>

{% for culturaldomain in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>CULTURAL SECTOR</th>
            <th>CULTURAL SECTOR DESCRIPTION</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
         <td>{{ culturaldomain.CultDomainName }}</td>
            <td>{{ culturaldomain.CultDomainDescription }}</td>
            <td with="7%">{{ link_to("culturaldomain/edit/" ~ culturaldomain.ID_CultDomain, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("culturaldomain/delete/" ~ culturaldomain.ID_CultDomain, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("culturaldomain/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("culturaldomain/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("culturaldomain/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("culturaldomain/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No cultural sector are recorded
{% endfor %}
