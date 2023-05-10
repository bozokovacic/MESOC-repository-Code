{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("dataprov/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("dataprov/new", "Create data provider") }}
    </li>
</ul>

{% for dataprov in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DATA PROVIDERS ID</th>
            <th>DATA PROVIDER</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ dataprov.ID_DataProv }}</td>
            <td>{{ dataprov.DataProvName }}</td>
            <td width="7%">{{ link_to("dataprov/edit/" ~ dataprov.ID_DataProv, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("dataprov/delete/" ~ dataprov.ID_DataProv, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("documentresearch/countryaddDataProv/" ~ dataprov.ID_DataProv,'<i class="glyphicon glyphicon-edit"></i> Add data provider to Research', "class": "btn btn-default") }}</td>        
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("dataprov/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("dataprov/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("dataprov/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("dataprov/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No data providers are recorded
{% endfor %}
