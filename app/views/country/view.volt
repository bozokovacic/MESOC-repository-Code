{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("country/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("country/new", "Create country") }}
    </li>
</ul>

{% for country in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>COUNTRY ID</th>
            <th>COUNTRY CODE</th>
            <th>COUNTRY</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ country.ID_Country }}</td>
            <td>{{ country.CountryCode }}</td>
            <td>{{ country.CountryName }}</td>
              {% switch country.ID_Country %}
                {% case  1  %}
                    {% break %}
                {% default %}
                    <td with="7%">{{ link_to("country/edit/" ~ country.ID_Country, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                    <td with="7%">{{ link_to("country/delete/" ~ country.ID_Country, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
                    <td width="7%">{{ link_to("documentlink/authoraddCountry/" ~ country.ID_Country,'<i class="glyphicon glyphicon-edit"></i> Add country to Author', "class": "btn btn-default") }}</td>        
              {% endswitch %} 
            </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("country/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("country/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("country/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("country/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No country are recorded
{% endfor %}
