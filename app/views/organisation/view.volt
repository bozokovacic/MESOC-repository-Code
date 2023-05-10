{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("organisation/index", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("organisation/new", "Create organisation") }}
    </li>
</ul>

{% for organisation in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ORGANISATION ID</th>
            <th>ORGANISATION</th>
            <th>ORGANISATION ADDRESS</th>
            <th>CITY</th>
            <th>ORGANISATION COUNTRY</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ organisation.ID_Organisation }}</td>
            <td>{{ organisation.OrgName }}</td>
            <td>{{ organisation.OrgAdress }}</td>
            <td>{{ organisation.getCity().CityName }}</td>
            <td>{{ organisation.getCountry().CountryName }}</td>
            <td width="7%">{{ link_to("organisation/edit/" ~ organisation.ID_Organisation, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("organisation/delete/" ~ organisation.ID_Organisation,'<i class="glyphicon glyphicon-remove"></i> Delete organisation', "class": "btn btn-default") }}</td>                
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("organisation/view", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("organisation/view?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("organisation/view?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("organisation/view?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No organisation are recorded
{% endfor %}
