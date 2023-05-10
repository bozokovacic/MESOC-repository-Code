{{ content() }}

<ul class="pager">
 <!-- <li class="previous">
        {{ link_to("documentwaitingroom", "&larr; Search") }}
     </li>
     <li class="next">
        {{ link_to("waitingroom/new", "New waitingroom") }}
    </li> -->
</ul>

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
            <td width="7%">{{ link_to("documentwaitingroom/pregled/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}
            {{ link_to("documentwaitingroom/edit/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}
            {{ link_to("documentwaitingroom/documentwaitingroomcultdomainsocimpact/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-edit"></i>Domain & CO theme', "class": "btn btn-default") }}
            {{ link_to("documentwaitingroom/check/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-upload"></i> Store', "class": "btn btn-primary") }}
            {{ link_to("documentwaitingroom/deletedocument/" ~ documentwaitingroom.ID_Doc, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-primary") }}           
            {{ documentwaitingroom.downloadlink  }}
            </td>
<!--             <td><a target = "_blank" href="/../uploads/Kupnja majice.docx" class="btn btn-default"><i class="glyphicon glyphicon-download"></i> Download</a></td> -->
 <!--              {% switch documentwaitingroom.ID_Role %}
                    {% case  2  %}
                      {% break %}
                    {% default  %}
                        <td width="7%">{{ link_to("documentwaitingroom/check/" ~ documentwaitingroom.ID_Template, '<i class="glyphicon glyphicon-remove"></i> Check', "class": "btn btn-default") }}</td> 
                      {% break %} 
                {% endswitch %} -->
    </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    {{ link_to("documentwaitingroom/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("documentwaitingroom/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("documentwaitingroom/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("documentwaitingroom/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
    {% endif %}
{% else %}
    No waitingroom are recorded
{% endfor %}
