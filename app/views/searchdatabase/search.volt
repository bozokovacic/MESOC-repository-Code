{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("searchdatabase/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("searchdatabase/new", "Create search database") }}
    </li>
</ul>

{% for searchdatabase in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>SEARCH DATABASE ID</th>
            <th>SEARCH DATABASE NAME</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ searchdatabase.ID_Database }}</td>
            <td>{{ searchdatabase.SearchDatabase }}</td>
            <td with="7%">{{ link_to("searchdatabase/edit/" ~ searchdatabase.ID_Database, '<i class="glyphicon glyphicon-edit"></i> Uredi', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("searchdatabase/delete/" ~ searchdatabase.ID_Database, '<i class="glyphicon glyphicon-remove"></i> Obriši', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("searchdatabase/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("searchdatabase/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("searchdatabase/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("searchdatabase/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No searchdatabase are recorded
{% endfor %}
