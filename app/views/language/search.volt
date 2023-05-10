{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("language", "Search") }}
    </li>
    <li class="next">
        {{ link_to("language/new", "Create language") }}
    </li>
</ul>

{% for language in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>LANGUAGE ID</th>
            <th>LANGUAGE</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ language.ID_Language }}</td>
            <td>{{ language.Language }}</td>
	     <td width="7%">{{ link_to("language/edit/" ~ language.ID_Language, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
             <td width="7%">{{ link_to("language/delete/" ~ language.ID_Language, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="4" align="right">
                <div class="btn-group">
                    {{ link_to("language/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("language/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("language/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("language/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
    {% endif %}
{% else %}
    No product types are recorded
{% endfor %}
