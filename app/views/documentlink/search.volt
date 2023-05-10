{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document", "Search") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New document") }}
    </li> -->
</ul>

{% for document in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>PUB. YEAR</th>
            <th>LINKS</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ document.ID_Doc }}</td>
			<td>{{ document.Title }}</td>
			<td>{{ document.Keywords }}</td>
			<td>{{ document.PubYear }}</td>
			<td>{{ document.Links }}</td>
			<td width="7%">{{ link_to("document/pregled/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}</td>
                        <td width="7%">{{ link_to("document/linksauthor/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Advance', "class": "btn btn-default") }}</td>
                        <td with="7%">{{ link_to("document/edit/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                        <td with="7%">{{ link_to("document/delete/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
    </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    {{ link_to("documents/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("documents/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("documents/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("documents/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
    {% endif %}
{% else %}
    No document are recorded
{% endfor %}
