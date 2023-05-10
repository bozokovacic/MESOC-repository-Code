{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("technique/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("technique/new", "Create technique") }}
    </li>
</ul>

{% for technique in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TECHNIQUE ID</th>
            <th>TECHNIQUE</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ technique.ID_Technique }}</td>
            <td>{{ technique.TechniqueName }}</td>
            <td with="7%">{{ link_to("technique/edit/" ~ technique.ID_Technique, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("technique/delete/" ~ technique.ID_Technique, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("documentlink/techniqueadd/" ~ technique.ID_Technique, ' Add to document', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("technique/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("technique/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("technique/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("technique/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No technique are recorded
{% endfor %}
