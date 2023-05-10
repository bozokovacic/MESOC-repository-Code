{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("products", "&larr; Natrag") }}
    </li>
    <li class="next">
        {{ link_to("products/new", "Novo djelovodstvo") }}
    </li>
</ul>

{% for product in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ŠIFRA</th>
            <th>SVOJSTVO</th>
            <th>SURADNIK</th>
            <th>DJELA</th>
            <th>STOPA DOBITI</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ product.id }}</td>
            <td>{{ product.getSvojstva().name }}</td>
			<td>{{ product.getSvojstva().name }}</td>
			<td>{{ product.getSvojstva().name }}</td>
			<td>${{ "%.2f"|format(product.price) }}</td>
            <td width="7%">{{ link_to("products/edit/" ~ product.id, '<i class="glyphicon glyphicon-edit"></i> Uredi', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("products/delete/" ~ product.id, '<i class="glyphicon glyphicon-remove"></i> Obriši', "class": "btn btn-default") }}</td>
        </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("products/search", '<i class="icon-fast-backward"></i> Prva', "class": "btn") }}
                    {{ link_to("products/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Prethodna', "class": "btn") }}
                    {{ link_to("products/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Sljedeća', "class": "btn") }}
                    {{ link_to("products/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Posljednja', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
    {% endif %}
{% else %}
    No products are recorded
{% endfor %}
