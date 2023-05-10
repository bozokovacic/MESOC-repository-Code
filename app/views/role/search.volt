{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("role/index", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("role/new", "Create role") }}
    </li>
</ul>

{% for role in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ROLE NUMBER</th>
            <th>ROLE</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ role.RoleNumber }}</td>
            <td>{{ role.RoleName }}</td>
            <td with="7%">{{ link_to("role/edit/" ~ role.ID_Role, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("role/delete/" ~ role.ID_Role, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("role/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("role/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("role/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("role/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No role are recorded
{% endfor %}
