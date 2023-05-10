{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("institution/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("institution/new", "Create institution") }}
    </li>
</ul>

{% for institution in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>INSTITUTION ID</th>
            <th>INSTITUTION</th>
            <th>INSTITUTION ADDRESS</th>
            <th>INSTITUTION COUNTRY</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ institution.ID_Institution }}</td>
            <td>{{ institution.InstName }}</td>
            <td>{{ institution.InstAdress }}</td>
            <td>{{ institution.getCountry().CountryName }}</td>
            <td width="7%">
                {% switch institution.ID_Institution %}
                    {% case  1  %}
                        {% break %}
                    {% default %}
                        <td width="7%">{{ link_to("institution/edit/" ~ institution.ID_Institution, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                        <td width="7%">{{ link_to("institution/delete/" ~ institution.ID_Institution,'<i class="glyphicon glyphicon-remove"></i> Delete institution', "class": "btn btn-default") }}</td>       
                        <td width="7%">{{ link_to("documentlink/authoraddInst/" ~ institution.ID_Institution,'<i class="glyphicon glyphicon-edit"></i> Add institution to Author', "class": "btn btn-default") }}</td>        
                    {% endswitch %} 
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("institution/view", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("institution/view?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("institution/view?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("institution/view?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No institution are recorded
{% endfor %}
