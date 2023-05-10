{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("teritcon/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("teritcon/new", "Create territorial context") }}
    </li>
</ul>

{% for teritcon in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TERITORIAL CONTEXT ID</th>
            <th>TERITORIAL CONTEXT NAME CODE</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ teritcon.ID_TeritCon }}</td>
            <td>{{ teritcon.TeritCon }}</td>
            <td with="7%">{{ link_to("teritcon/edit/" ~ teritcon.ID_TeritCon, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
<!--            <td with="7%">{{ link_to("teritcon/delete/" ~ teritcon.ID_TeritCon, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td> -->
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("teritcon/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("teritcon/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("teritcon/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("teritcon/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No teritcon are recorded
{% endfor %}
