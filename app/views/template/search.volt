{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("template/search", "&larr; Search") }}
    </li>
<!--    <li class="next">
        {{ link_to("template/new", "New template") }}
    </li> -->
</ul>

{% for template in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>USER NAME</th>
            <th>PARTNER ACRONIM</th>
            <th>ID PROPOSAL</th>
            <th>TITLE</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ template.ID_Proposal }}</td>
	    <td>{{ template.Title }}</td>
	    <td>{{ template.Keywords }}</td>
	    <td>{{ template.PubYear }}</td>
            <td>{{ template.Links }}</td>
	    <td>{{ template.getPartner().PartnerAcr }}</td>
            {% set checked = template.Checked %}
            <td width="7%"> {{ link_to("template/pregled/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}
                {% switch ID_Role %}
                    {% case  2  %}
                        </td>
                      {% break %}
                    {% case  3  %}
                        </td>
                      {% break %}
                    {% default  %}
                        {% if checked == 0 %}
                            {{ link_to("template/check/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-remove"></i> Store ', "class": "btn btn-primary") }}                       
                            {{ link_to("template/delete/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-remove"></i> Delete ', "class": "btn btn-primary") }} </td>                              
                        {% endif %}
                      {% break %} 
                {% endswitch %}                             
            
    </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    {{ link_to("templates/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("templates/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("templates/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("templates/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
    {% endif %}
{% else %}
    No template are recorded
{% endfor %}
