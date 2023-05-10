{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("companies/index", "&larr; Natrag") }}
    </li>
    <li class="pull-right">
        {{ link_to("companies/new", "Stvori suradnika") }}
    </li>
</ul>

{% for companies in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Šifra</th>
            <th>Ime</th>
            <th>Adresa</th>
            <th>PPT</th>
            <th>Mjesto</th>
			<th>Telefon</th>
			<th>Prezime</th>
			<th>Ime</th>
			<th>Umjetničko ime</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ companies.id }}</td>
            <td>{{ companies.naziv }}</td>
            <td>{{ companies.ulica }}</td>
			<td>{{ companies.ppt }}</td>
			<td>{{ companies.mjesto }}</td>
			<td>{{ companies.tel }}</td>
            <td>{{ companies.prezime }}</td>
			<td>{{ companies.ime }}</td>
			<td>{{ companies.umjetickoime }}</td>
            <td width="7%">{{ link_to("companies/edit/" ~ companies.id, '<i class="glyphicon glyphicon-edit"></i> Uredi', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("companies/delete/" ~ companies.id, '<i class="glyphicon glyphicon-remove"></i> Obriši', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("companies/search", '<i class="icon-fast-backward"></i> Prva', "class": "btn") }}
                    {{ link_to("companies/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Prethodna', "class": "btn") }}
                    {{ link_to("companies/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Sljedeća', "class": "btn") }}
                    {{ link_to("companies/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Posljednja', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No companies are recorded
{% endfor %}
