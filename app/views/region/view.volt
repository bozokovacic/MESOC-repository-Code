{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("region/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("region/new", "Create region") }}
    </li>
</ul>

{% for region in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>REGION ID</th>
            <th>REGION</th>
            <th>TERRITORIAL CONTEXT</th>
            <th>NUTS CATEGORY</th>
            <th>COUNTRY</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ region.ID_Region }}</td>
            <td>{{ region.RegionName }}</td>
            <td>{{ region.RegionTeritCon }}</td>
            <td>{{ region.NUTSType }}</td>
            <td>{{ region.getCountry().CountryName }}</td>
            {% switch region.ID_Region %}
                    {% case  1  %}
                        {% break %}
                    {% default %}
                        <td width="7%">{{ link_to("region/edit/" ~ region.ID_Region, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                        <td width="7%">{{ link_to("region/delete/" ~ region.ID_Region, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
                        <td width="7%">{{ link_to("documentresearch/countryaddRegion/" ~ region.ID_Region,'<i class="glyphicon glyphicon-edit"></i> Add region to Research', "class": "btn btn-default") }}</td>        
            {% endswitch %}               
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("region/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("region/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("region/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("region/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No region are recorded
{% endfor %}
