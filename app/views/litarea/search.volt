{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("litarea/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("litarea/new", "Create liter. area") }}
    </li>
</ul>

{% for litarea in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ID_LitArea</th>
            <th>LITERATURE AREA</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ litarea.ID_LitArea }}</td>
            <td>{{ litarea.LiteratureArea }}</td>
            <td with="7%">{{ link_to("litarea/edit/" ~ litarea.ID_LitArea, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("litarea/delete/" ~ litarea.ID_LitArea, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("litarea/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("litarea/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("litarea/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("litarea/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No litarea are recorded
{% endfor %}
