{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("city/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("city/new", "Create city") }}
    </li>
</ul>

{% for city in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>CITY ID </th>
            <th>CITY CODE</th>
            <th>CITY</th>
            <th>COUNTRY</th>
            <th>LATITUDE</th>
            <th>LONGITUDE</th>
            <th>TERRIT. CONTEXT</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ city.ID_City }}</td>
            <td>{{ city.CityCode }}</td>
            <td>{{ city.CityName }}</td>
            <td>{{ city.getCountry().CountryName }}</td>
            <td>{{ city.LATITUDE }}</td>
            <td>{{ city.LONGITUDE }}</td>
            <td>{{ city.CityTeritCon }}</td>
           {% switch city.ID_City %}
                    {% case  1  %}
                        {% break %}
                    {% default %}
                        <td with="7%">{{ link_to("city/edit/" ~ city.ID_City, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                        <td with="7%">{{ link_to("city/delete/" ~ city.ID_City, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
                        <td width="7%">{{ link_to("documentresearch/countryaddCity/" ~ city.ID_City,'<i class="glyphicon glyphicon-edit"></i> Add city to Research', "class": "btn btn-default") }}</td>        
            {% endswitch %}      
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("city/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("city/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("city/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("city/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No city are recorded
{% endfor %}

