{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("type/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("type/new", "Create document type") }}
    </li>
</ul>

{% for type in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT TYPE ID</th>
            <th>DOCUMENT TYPE</th>
            <th>DOCUMENT CATEGORY</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        
        {% set link1 = type.ID_Type~"-1" %}
        {% set link2 = type.ID_Type~"-2" %}
        {% set link3 = type.ID_Type~"-3" %}
        
        <tr>
            <td>{{ type.ID_Type }}</td>
            <td>{{ type.DocType }}</td>
            <td>                   
                {{ type.Category }}
            </td>
            <td with="7%">{{ link_to("type/category/" ~ type.ID_Type, 'Category', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("type/edit/" ~ type.ID_Type, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("type/delete/" ~ type.ID_Type, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("type/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("type/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("type/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("type/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No type are recorded
{% endfor %}
