{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("category/index", "Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("category/new", "Create document category") }}
    </li>
</ul>

{% for category in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT CATEGORY ID</th>
            <th>DOCUMENT CATEGORY NAME</th>
            <th>DOCUMENT CATEGORY DESCRIPTION</th>
         </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ category.ID_Category }}</td>
            <td>{{ category.CategoryName }}</td>
            <td>{{ category.CategoryDescription }}</td>
            <td with="7%">{{ link_to("category/edit/" ~ category.ID_Category, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td with="7%">{{ link_to("category/delete/" ~ category.ID_Category, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("category/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("category/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("category/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("category/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No category are recorded
{% endfor %}
