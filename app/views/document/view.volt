{{ content() }}

<ul class="pager">
    <li class="previous">
         {% if View == "SEARCH" %}           
		{{ link_to("document", "Search") }}              
         {% endif  %} 
	 {% if View == "ALL" %}           
		{{ link_to("document", "View") }}              
         {% endif  %} 

    </li>
    <li class="next">
         {% if Role == 4 %}           
		 {{ link_to("document/new/" ~ "1", "New undefined document") }}  
                {{ link_to("document/new/" ~ "3", "New grey literature") }}                                       
                {{ link_to("document/new/" ~ "2", "New scientific document ") }}   
                {{ link_to("documentwaitingroom/view/", "Waiting room ") }}   
<!--                {{ link_to("document/new/" ~ "0", "Waiting room ") }}   -->
            {% endif  %} 
            {% if Role == 3 %}            
<!--            {{ link_to("document/new/" ~ "-3", "New Tagret groups") }}  -->                                
                {{ link_to("document/new/" ~ "-2", "New grey literature") }}                            
            {% endif  %} 
    </li> 
</ul>

{% for document in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>YEAR OF PUBLICATION</th>
            <th>DOCUMENT TYPE</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ document.ID_Doc }}</td>
			<td>{{ document.Title }}</td>
			<td>{{ document.Keywords }}</td>
			<td>{{ document.PubYear }}</td>
			<td>{{ document.getType().DocType }}</td>
			<td width="7%">{{ link_to("document/pregled/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}</td>
		        {% if Role == 4 %}            
		                <td width="7%">{{ link_to("documentlink/linksauthor/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Advance', "class": "btn btn-default") }}</td>
                	        <td with="7%">{{ link_to("document/edit/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                                <td with="7%">{{ link_to("document/delete/" ~ document.ID_Doc, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
		        {% endif  %} 
    </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    {{ link_to("document/view?page=" ~ page.first, '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("document/view?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("document/view?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("document/view?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
