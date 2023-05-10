{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("transtionvar/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("transtionvar/new", "Create transtion variable") }}
    </li>
</ul>

{% for transtionvar in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TRANSITION VARIABLES ID</th>
            <th>TRANSITION VARIABLES NAME</th>
            <th>TRANSITION VARIABLES DESCRIPTION</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ transtionvar.ID_Transvar }}</td>
            <td>{{ transtionvar.TransvarName }}</td>
            <td>{{ transitionvar.TransvarDescription }}</td>
                <td width="7%">{{ link_to("transtionvar/edit/" ~ transtionvar.ID_Transvar, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("transtionvar/delete/" ~ transtionvar.ID_Transvar, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("transtionvar/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("transtionvar/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("transtionvar/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("transtionvar/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
