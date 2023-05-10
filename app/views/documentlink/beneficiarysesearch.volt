{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document/search", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>


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

        <tr>
            <td>{{ document.ID_Doc }}</td>
            <td>{{ document.Title }}</td>
            <td>{{ document.Keywords }}</td>
            <td>{{ document.PubYear }}</td>
            <td>{{ document.Links }}</td>
	</tr>

    </tbody>
    
</table>

             {{ link_to("documentlink/linksauthor/" ~ document.ID_Doc, 'Author', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkscountry/" ~ document.ID_Doc, 'Research', "class": "btn btn-primary") }}   
             {{ link_to("documentlink/linkssearchdatabase/" ~ document.ID_Doc, 'Search database', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkstechnique/" ~ document.ID_Doc, 'Technique', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksbeneficiary/" ~ document.ID_Doc, 'Beneficiary', "class": "btn btn-primary") }} 

 <h3>BENEFICIARY</h3> 

{% for beneficiary in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>BENEFICIARY ID</th>            
            <th>BENEFICIARY NAME</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ beneficiary.ID_Beneficiary }}</td>
        <td>{{ beneficiary.BeneficiaryName }}</td>
        <td with="7%">{{ link_to("documentlink/beneficiaryadd/" ~ beneficiary.ID_Beneficiary, ' Add to document', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No beneficiary are recorded.
{% endfor %}  
