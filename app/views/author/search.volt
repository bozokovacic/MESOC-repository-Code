{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("author/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("author/new", "Create author") }}
    </li>
</ul>

{% for author in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>AUHOR ID</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>MIDDENAME INITIAL</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ author.ID_Author }}</td>
            <td>{{ author.FirstName }}</td>
            <td>{{ author.LastName }}</td>
            <td>{{ author.MiddleNameInitial }}</td>
            <td with="7%">{{ link_to("author/edit/" ~ author.ID_Author, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("author/delete/" ~ author.ID_Author, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("author/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No author are recorded
{% endfor %}
