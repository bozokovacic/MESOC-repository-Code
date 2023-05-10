{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("template", "&larr; Search") }}
    </li>
    <li class="next">
        {{ link_to("template/new", "New Proposal") }}
    </li> 
</ul>

<h3>DOCUMENT PROPOSAL</h3>
<BR>

{{ link_to("template/view/" ~ "0", ' ALL DOCUMENTS', "class": "btn btn-default") }}  
{{ link_to("template/view/" ~ "1", ' STORED TO REPOSITORY', "class": "btn btn-default") }}  
{{ link_to("template/view/" ~ "2", ' REJECTED', "class": "btn btn-default") }}   
{{ link_to("template/view/" ~ "3", ' WAITING', "class": "btn btn-default") }}

<BR><BR>

{% for template in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th style="vertical-align:top", colspan="8"> <H4> SELECTED:  {{ viewtype  }} </H4></th>
        </tr>
        <tr>
            <th>USER NAME</th>
            <th>PARTNER ACRONIM</th>
            <th>ID PROPOSAL</th>
            <th>TITLE</th>
            <th>CREATED</th>
            <th>ID DOCUMENT</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ template.getUsers().name }}</td>
            <td>{{ template.getPartner().PartnerAcr }}</td>
            <td>{{ template.ID_Proposal }}</td>
            <td>{{ template.Title }}</td>
            <td>{{ template.Created_at }}</td>
            <td>{{ template.ID_Doc }}</td>
            {% set checked = template.Checked %}
            <td width="7%">
                {% switch ID_Role %}
                    {% case  2  %}
                        </td>
                      {% break %}
                    {% case  3  %}
			{% if checked == 0 %}
	    		   {{ link_to("template/edit/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}                         
                           {{ link_to("template/templatecultdomainsocimpact/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Domain & CO theme', "class": "btn btn-default") }}                           
			{% endif %}
			   {{ link_to("template/pregled/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}
                           </td>
                      {% break %}
                    {% default  %}
	    		   {{ link_to("template/edit/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}         
			   {{ link_to("template/pregled/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}
                           {{ link_to("template/templatecultdomainsocimpact/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-edit"></i> Domain & CO theme', "class": "btn btn-default") }}                           
	                        {% if checked == 0 %}
                            {{ link_to("template/check/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-remove"></i> Store ', "class": "btn btn-primary") }}                       
                            {{ link_to("template/delete/" ~ template.ID_Proposal, '<i class="glyphicon glyphicon-remove"></i> Delete ', "class": "btn btn-primary") }} </td>                              
                        {% endif %}
                      {% break %} 
                {% endswitch %}                             
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("template/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("template/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("template/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}               
                    {{ link_to("template/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No document prooposal are recorded.
{% endfor %}
