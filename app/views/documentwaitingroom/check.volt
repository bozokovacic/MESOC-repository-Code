{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("documentwaitingroom", "&larr; Search") }}
    </li>
<!--    <li class="pull-right">
        {{ link_to("documentwaitingroom/new", "Create documentwaitingroom") }}
    </li> -->
</ul>

<h3>TEMPLATE DATA</h3>


{% for documentwaitingroom in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ID DOCUMENT</th>
            <th>TITLE</th>
            <th>ABSTRACT</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ documentwaitingroom.ID_Doc }}</td>
            <td>{{ documentwaitingroom.Title }}</td>
            <td>{{ documentwaitingroom.Summary }}</td>
            <td width="7%">{{ link_to("documentwaitingroom/edit/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("documentwaitingroom/documentwaitingroomcultdomainsocimpact/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Cult domain & soc. impact', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("documentwaitingroom/pregled/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("documentwaitingroom/check/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-remove"></i> Checked', "class": "btn btn-primary") }}</td> 
 <!--               {% switch documentwaitingroom.ID_Role %}
                    {% case  2  %}
                      {% break %}
                    {% default  %}
                        <td width="7%">{{ link_to("documentwaitingroom/check/" ~ documentwaitingroom.ID_Template, '<i class="glyphicon glyphicon-remove"></i> Check', "class": "btn btn-default") }}</td> 
                      {% break %} 
                {% endswitch %} -->
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("documentwaitingroom/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("documentwaitingroom/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("documentwaitingroom/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("documentwaitingroom/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No documentwaitingroom are recorded
{% endfor %}
