{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("transitionvar/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("transitionvar/new", "Create transition variable") }}
    </li>
</ul>

{% for transitionvar in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TRANSITION VARIABLE ID</th>
            <th>TRANSITION VARIABLE NAME</th>
            <th>TRANSITION VARIABLE DESCRIPTION</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ transitionvar.ID_Transvar }}</td>
            <td>{{ transitionvar.TransvarName }}</td>
            <td>{{ transitionvar.TransvarDescription }}</td>
            <td width="7%">{{ link_to("transitionvar/edit/" ~ transitionvar.ID_Transvar, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("transitionvar/delete/" ~ transitionvar.ID_Transvar, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("transitionvar/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("transitionvar/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("transitionvar/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("transitionvar/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
